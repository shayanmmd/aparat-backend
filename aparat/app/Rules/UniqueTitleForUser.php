<?php

namespace App\Rules;

use App\Models\Playlist;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueTitleForUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Playlist::where([
            'user-id' => Auth::user()->id,
            'title' => $value
        ])->exists();

        if ($exists)
            $fail('این عنوان لیست پخش از قبل برای شما موجود است');
    }
}
