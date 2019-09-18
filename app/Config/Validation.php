<?php namespace Config;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var array
     */
    public $ruleSets = [
        \CodeIgniter\Validation\Rules::class,
        \CodeIgniter\Validation\FormatRules::class,
        \CodeIgniter\Validation\FileRules::class,
        \CodeIgniter\Validation\CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array
     */
    public $templates = [
        'list' => 'CodeIgniter\Validation\Views\list',
        'single' => 'App\Views\layouts\components\error_single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    public $roles = [
        'role' => 'required|max_length[50]|is_unique[roles.role]',
        'description' => 'max_length[500]',
        'permissions' => 'required'
    ];

    public $users = [
        'name' => 'trim|required|max_length[50]',
        'username' => 'required|max_length[50]|is_unique[users.username]',
        'email' => 'required|max_length[50]|is_unique[users.email]',
        'password' => 'min_length[6]',
        'confirm_password' => 'matches[password]',
        'status' => 'required',
        'avatar' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]',
        'roles' => 'required',
    ];
}
