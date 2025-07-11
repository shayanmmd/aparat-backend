<?php

namespace App\Rules;

use App\Models\Playlist;
use Auth;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OwnPlaylistId implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Playlist::where(
            [
                'id' => $value,
                'user-id' =>  Auth::user()->id,
            ]
        )->exists();

        if (!$exists)
            $fail('این لیست پخش برای این کاربر نیست');
    }
}
