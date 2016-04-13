<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Hashing\BcryptHasher;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hasher = new BcryptHasher();
        $admin = new User;
        $admin->setEmail('polladmin@cloudhorizon.com');
        $admin->setPassword($hasher->make('polladmin'));
        $admin->setType(User::TYPE_ADMIN);
        $admin->setStatus(User::STATUS_ACTIVE);
        $admin->setVerified(true);

        $admin->save();
    }
}
