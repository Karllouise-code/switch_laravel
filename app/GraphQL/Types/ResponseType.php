<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ResponseType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'response_type',
        'description'   => 'A response type',
    ];

    public function fields(): array
    {
        return [
            'error' => [
                'type' => Type::boolean(),
            ],
            'message' => [
                'type' => Type::string(),
            ],
            'access_token' => [
                'type' => Type::string(),
            ],
        ];
    }
}