<?php 

namespace App\Src\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Src\ValueObject\ProductValueObject;

class ProductRepository extends AbstractRepository {
 
    /**
     * Specify Model class name
     *
     * @return Model
     */
    function model()
    {
        return 'App\Src\Models\Product';
    }

    /**
     * Description
     * @param type $sourceUrl 
     * @return type
     */
    public function fetchByUrl($sourceUrl) {
        return $this->model->where('source_url', $sourceUrl)->first();
    }

    /**
     * Store batch or single product
     * @param mixed $mixed 
     * @return type
     */
    public function store(ProductValueObject $product) {
        $sourceUrl = $product->getSourceUrl();
        $record = $this->fetchByUrl($sourceUrl);

        if(!$record) {
            error_log("Creating record");
            $data = $product->toArray();
            unset($data['tag']);
            $tag = $product->getTag();
            $data['tags'] = json_encode([$tag => $tag]);
            $record = $this->create($data);
        } else {
            error_log("Updating record");
            $data = $product->toArray();
            unset($data['tag']);
            $tag = $product->getTag();
                
            $tags = $record->tags;
            if(!isset($tags->$tag)) {
                $tags->$tag = $tag;
            }

            $data['tags'] = json_encode($tags);
            $record = $this->update($record->id, $data);
        }

        return $record;
    }
}