<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        \App\Validation\UserRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    public $registration = [
        'name' => [
            'rules' => 'required|min_length[3]|max_length[20]',
            'errors' => [
                'required' => 'Name field is required',
            ],
        ],
        'contact' => [
            'rules' => 'required|min_length[9]|max_length[20]',
            'errors' => [

            ],
        ],
        'email' => [
            'rules' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user_login.email]',
            'errors' => [
                'is_unique' => 'This email has already been registered. Please login to continue',
            ],
        ],
        'password' => [
            'rules' => 'required|min_length[8]|max_length[255]',
            'errors' => [

            ],
        ],
        'confirmPassword' => [
            'rules' => 'matches[password]',
            'errors' => [

            ],
        ],
    ];
    public $registration_errors = [
        'email'    => [
            'is_unique' => 'This email address is already taken',
        ],
    ];
}
