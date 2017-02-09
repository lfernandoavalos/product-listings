<?php 

namespace App\Src\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;


class FavoriteRepository extends AbstractRepository {
 
    /**
     * Specify Model class name
     *
     * @return Model
     */
    function model()
    {
        return 'App\Src\Models\Favorite';
    }

    /**
     * Fetch user favorites
     * @param $userId
     * @return Collection
     */
    public function fetchByUser($userId) {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * 
     * @param type $id 
     * @return type
     */
    public function find($id) {
        return $this->model->with('product')->find($id);
    }

    /**
     * Create new favorite resoruce
     * @param type $data 
     * @return type
     */
    public function create($data) {
        $favorite = $this->model->firstOrCreate($data);
        return $this->find($favorite->id);
    }
}