<?php
namespace App\GraphQL\Mutations;

use Closure;
use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Log;

class UserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UserMutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('response_type');
    }

    public function args(): array
    {
        return [
            'user' => ['type' => GraphQL::type('user_input')],
        ];
    }

    protected function rules(array $args = []): array
    {
        $user = $args['user'];
        $rules = [];
        if ($user['action_type'] == "register") {
            $rules['user.name'] = ['required'];
            $rules['user.email'] = ['required', 'email', 'unique:tblUsers,fldUsersEmail'];
            $rules['user.password'] = ['required', 'min:8'];
            $rules['user.password_confirm'] = ['required', 'same:user.password'];
        }

        else if ($user['action_type'] == "login") {
            $rules['user.email'] = ['required', 'email'];
            $rules['user.password'] = ['required'];
        }

        return $rules;
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'user.name.required' => 'Please enter your name',
            'user.email.required' => 'Please enter your email',
            'user.email.email' => 'Please enter a valid email',
            'user.email.unique' => 'Email already exists',
            'user.password.required' => 'Please enter your password',
            'user.password.min' => 'Password must be at least 8 characters',
            'user.password_confirm.required' => 'Please confirm your password',
            'user.password_confirm.same' => 'Passwords must match',
        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $user_model = new User();
        $response_obj = new \stdClass();

        $user = $args['user'];

        if ($user['action_type'] == "register") {
            $response_obj = $user_model->onRegister($user);
        }

        else if ($user['action_type'] == "login") {
            $response_obj = $user_model->onLogin($user);
        }

        return $response_obj;

    }
}