<?php

namespace App;

use App\Helpers\ClientFactory;

class BlogManager
{
    private $client;
    private $index = 'blog_posts';

    public function __construct()
    {
        $this->client = ClientFactory::make('http://elasticsearch:9200/');
        $this->createIndex();
    }

    private function createIndex()
    {
        try {
            $mapping = [
                'mappings' => [
                    'properties' => [
                        'id' => ['type' => 'keyword'],
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'standard'
                        ],
                        'content' => [
                            'type' => 'text',
                            'analyzer' => 'standard'
                        ],
                        'author' => ['type' => 'keyword'],
                        'tags' => ['type' => 'keyword'],
                        'category' => ['type' => 'keyword'],
                        'created_at' => ['type' => 'date'],
                        'views' => ['type' => 'integer'],
                        'likes' => ['type' => 'integer']
                    ]
                ]
            ];

            $this->client->put($this->index, [
                'json' => $mapping
            ]);
            echo "Индекс '{$this->index}' создан успешно<br>";
        } catch (\Exception $e) {
            echo "Индекс '{$this->index}' уже существует или ошибка: " . $e->getMessage() . "<br>";
        }
    }

    public function createPost($data)
    {
        $id = uniqid();
        $postData = [
            'id' => $id,
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => $data['author'],
            'tags' => $data['tags'],
            'category' => $data['category'],
            'created_at' => date('Y-m-d\TH:i:s\Z'),
            'views' => 0,
            'likes' => 0
        ];

        $response = $this->client->post("{$this->index}/_doc/{$id}", [
            'json' => $postData
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getAllPosts($size = 10)
    {
        $query = [
            'query' => [
                'match_all' => new \stdClass()
            ],
            'sort' => [
                ['created_at' => ['order' => 'desc']]
            ],
            'size' => $size
        ];

        $response = $this->client->get("{$this->index}/_search", [
            'json' => $query
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        $posts = [];
        foreach ($data['hits']['hits'] as $hit) {
            $posts[] = $hit['_source'];
        }

        return $posts;
    }

    public function searchPosts($searchTerm)
    {
        $query = [
            'query' => [
                'multi_match' => [
                    'query' => $searchTerm,
                    'fields' => ['title^2', 'content', 'author', 'tags'],
                    'fuzziness' => 'AUTO'
                ]
            ],
            'sort' => [
                ['_score' => ['order' => 'desc']],
                ['created_at' => ['order' => 'desc']]
            ]
        ];

        $response = $this->client->get("{$this->index}/_search", [
            'json' => $query
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        $results = [];
        foreach ($data['hits']['hits'] as $hit) {
            $results[] = [
                'post' => $hit['_source'],
                'score' => $hit['_score']
            ];
        }

        return $results;
    }

    public function getPostsByCategory($category)
    {
        $query = [
            'query' => [
                'term' => [
                    'category' => $category
                ]
            ],
            'sort' => [
                ['created_at' => ['order' => 'desc']]
            ]
        ];

        $response = $this->client->get("{$this->index}/_search", [
            'json' => $query
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        $posts = [];
        foreach ($data['hits']['hits'] as $hit) {
            $posts[] = $hit['_source'];
        }

        return $posts;
    }

    public function updatePostViews($postId, $views)
    {
        $script = [
            'script' => [
                'source' => 'ctx._source.views = params.views',
                'lang' => 'painless',
                'params' => [
                    'views' => $views
                ]
            ]
        ];

        $this->client->post("{$this->index}/_update/{$postId}", [
            'json' => $script
        ]);
    }

    public function getPopularPosts($limit = 5)
    {
        $query = [
            'query' => [
                'match_all' => new \stdClass()
            ],
            'sort' => [
                ['views' => ['order' => 'desc']]
            ],
            'size' => $limit
        ];

        $response = $this->client->get("{$this->index}/_search", [
            'json' => $query
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        
        $posts = [];
        foreach ($data['hits']['hits'] as $hit) {
            $posts[] = $hit['_source'];
        }

        return $posts;
    }
}