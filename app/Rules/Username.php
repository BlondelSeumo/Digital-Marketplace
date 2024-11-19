<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Username implements Rule
{
    protected $restrictedUsernames;

    public function __construct()
    {
        $this->restrictedUsernames = [
            "admin",
            "user",
            "root",
            "superuser",
            "moderator",
            "administrator",
            "sysadmin",
            "support",
            "webmaster",
            "manager",
            "owner",
            "test",
            "guest",
            "demo",
            "anonymous",
            "system",
            "backup",
            "info",
            "help",
            "contact",
            "sales",
            "security",
            "tech",
            "finance",
            "billing",
            "legal",
            "service",
            "nobody",
            "nopass",
            "password",
            "qwerty",
            "welcome",
            "profile",
            "portfolio",
            "followers",
            "following",
            "reviews",
            "category",
            "categories",
            "items",
            "item",
            "directory",
            "domain",
            "download",
            "downloads",
            "edit",
            "editor",
            "email",
            "ecommerce",
            "forum",
            "forums",
            "favorite",
            "feedback",
            "follow",
            "files",
            "gadget",
            "gadgets",
            "games",
            "group",
            "groups",
            "homepage",
            "hosting",
            "hostname",
            "httpd",
            "https",
            "information",
            "image",
            "images",
            "index",
            "invite",
            "intranet",
            "indice",
            "iphone",
            "javascript",
            "knowledgebase",
            "lists",
            "websites",
            "workshop",
            "yourname",
            "yourusername",
            "yoursite",
            "yourdomain",
        ];
    }

    public function passes($attribute, $value)
    {
        $value = strtolower($value);
        if (in_array($value, $this->restrictedUsernames)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return __('validation.username');
    }
}