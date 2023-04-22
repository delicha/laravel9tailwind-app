<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Participation extends Model
{
    use HasFactory;

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'participations';

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'participations', 'user_id', 'post_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'participations', 'post_id', 'user_id');
    }

    public function insertParticipation($user_id, $request)
    {
        $result = $this->create([
            'user_id'      => $user_id,
            'post_id'      => request()->get('post_id'),
            'status'       => $request->status,
        ]);
        return $result;
    }
}
