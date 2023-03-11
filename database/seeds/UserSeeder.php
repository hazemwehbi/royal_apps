<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     // create default user account
        $AdminUser = User::create([
            'id'=>15,
            'name' => 'Superadmin',
            'email' => 'ahsoka.tano@q.agency',
            'password' => Hash::make('Kryze4President'),
           'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjc4NTYxNTY4LCJleHAiOjE2Nzg1NjUxNjgsIm5iZiI6MTY3ODU2MTU2OCwianRpIjoiQk5ib3MwNWhRTXJ2UDN1VCIsInN1YiI6IjEyIiwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.CKB-_ihPuK7kiPfmdBUlJ7yI8HwFEjCHgoMInENKp0Y'
        ]);
    }
}
