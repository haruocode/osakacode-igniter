<?php
/**
 * Created by PhpStorm.
 * User: hiennq
 * Date: 5/5/16
 * Time: 15:16
 */
namespace Solid\Repositories;

class LogLikeRepository extends BaseRepository implements Repository {

    public function save()
    {
        // TODO: Implement save() method.
        $this->checkModel();
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
        $this->checkModel();
        $list = $this->model->get_all();
        return $list ?: [];
    }

    public function findById($postId)
    {
        // TODO: Implement findById() method.
        $this->checkModel();
        $records = $this->model->fields('user_name')
            ->where(['post_id'=>$postId])
            ->get_all();
        return $records;
    }

    public function isUserLike($postId,$userId){
        $this->checkModel();
        $records = $this->model->fields('user_id')
            ->where(['post_id'=>$postId,'user_id'=>$userId])
            ->get();
        return $records;
    }

    public function like($postId,$userId,$userName){
        $this->model->insert(['user_id'=>$userId,'post_id'=>$postId,'user_name'=>$userName]);
    }

    public function unLike($postId,$userId){
        $this->model->delete(['user_id'=>$userId,'post_id'=>$postId]);
    }
    
}