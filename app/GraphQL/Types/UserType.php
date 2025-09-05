<?php
namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'user_type',
        'description'   => 'A user type',
    ];

    public function fields(): array
    {
        return [
            'name' => [
                'type' => Type::string(),
                'alias' => 'fldUsersName',
            ],
            'email' => [
                'type' => Type::string(),
                'alias' => 'fldUsersEmail',
            ],
        ];
    }
}