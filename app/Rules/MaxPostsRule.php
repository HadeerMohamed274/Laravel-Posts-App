<?php

namespace App\Rules;

use App\Models\Post;
use Closure;
use GuzzleHttp\Psr7\Message;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Mail\Message as MailMessage;
use Illuminate\Support\Facades\Auth;

class MaxPostsRule implements ValidationRule
{
    protected $maxPosts;

    public function __construct($maxPosts = 3)
    {
        $this->maxPosts = $maxPosts;
    }

   
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = Auth::user(); 
        $postCount = Post::where('creator_id')->count();

        if ($postCount >= $this->maxPosts) {
            $fail("You have reached the maximum number of allowed posts ({$this->maxPosts}).");
        }
    }
}
