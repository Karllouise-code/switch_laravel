<?php
namespace App\GraphQL\Queries;

use Closure;
use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'UserQuery',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user_type'));
    }

    public function args(): array
    {
        return [
            'action_type' => ['type' => Type::string()],
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user_model = new User();

        if ($args['action_type'] == "display_user") {
            $user[] = $user_model->displayUser();
        }

        return $user;
    }
}