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
        \App\Validations\Password::class,
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
    public $login = [
        'username' => 'required|max_length[50]',
        'password' => 'required|max_length[50]',
        'remember' => 'if_exist|in_list[,0,1,on]',
    ];

    public $register = [
        'name' => 'trim|required|max_length[50]',
        'username' => 'required|max_length[50]|is_unique[users.username]',
        'email' => 'required|max_length[50]|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'agreement' => 'required|in_list[,1,on]',
    ];

    public $recover = [
        'email' => 'required|max_length[50]|valid_email',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'matches[password]',
    ];

    public $roles = [
        'role' => 'required|max_length[50]|is_unique[roles.role]',
        'description' => 'max_length[500]',
        'permissions' => 'required'
    ];

    public $users = [
        'name' => 'trim|required|max_length[50]',
        'username' => 'required|max_length[50]|is_unique[users.username]',
        'email' => 'required|max_length[50]|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'matches[password]',
        'status' => 'required',
        'avatar' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]',
        'roles' => 'required',
    ];

    public $wishlists = [
        'wish' => 'trim|required|max_length[50]',
        'target' => 'required|max_length[20]',
        'description' => 'max_length[500]',
    ];
}
