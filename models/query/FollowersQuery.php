<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Followers]].
 *
 * @see \app\models\Followers
 */
class FollowersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Followers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Followers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function isFollowing($followerId, $userId)
    {
        return $this->andWhere([
            'follower_uuid'=>$followerId,
            'user_uuid'=>$userId
        ]);
    }


}

