<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    protected function getClass()
    {
        return User::class;
    }

    public function create($data)
    {
        $data = $this->hashPassword($data);

        return parent::create($data);
    }

    public function firstOrCreate($data)
    {
        $data = $this->hashPassword($data);

        return parent::firstOrCreate($data);
    }

    public function update($id, $data)
    {
        $data = $this->hashPassword($data);

        return parent::update($id, $data);
    }

    private function hashPassword($data)
    {
        $data['password'] = $data['password'] ?? null;
        if (!$data['password']) {
            unset($data['password']);
            unset($data['password_confirmation']);
        } else {
            $data['password'] = \Hash::Make($data['password']);
        }

        return $data;
    }
}
