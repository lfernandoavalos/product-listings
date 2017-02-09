<?php 

namespace App\Src\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use App\Src\ValueObject\ProductValueObject;
use App\Src\Models\Product;

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
        return $this->model->where('source_url', $sourceUrl)->where('current', 1)->first();
    }

    /**
     * Description
     * @param type $id 
     * @return type
     */
    public function find($id) {
        return $this->model->where('id', $id)->where('current', 1)->first();
    }

    /**
     * 
     * @param type $data 
     * @return type
     */
    private function createTempRecord(ProductValueObject $product, $id) {
        $data = $product->toArray();
        unset($data['tag']);
        $data['tags'] = json_encode($product->getTag());
        $data['id'] = $id;
        return $this->create($data);
    }

    /**
     * Store batch or single product
     * @param mixed $mixed 
     * @return type
     */
    public function store(ProductValueObject $product) {
        $sourceUrl = $product->getSourceUrl();
        $record = $this->fetchByUrl($sourceUrl);


        // Price has changed create a new temp record
        if($record) {
            $createTempRecord = false;
            // Create new temp record when price has changed
            if($record->price != $product->getPrice() && $product->getPrice()) {
                $createTempRecord = true;
                error_log("There was change in price");
            }

            // Create new temp record when description has changed
            if($record->description != $product->getDescription() && $product->getDescription()) {
                $createTempRecord = true;
                error_log("There was change in description");
            }

            // Create new temp record when tags have changed
            $tag = $product->getTag();
            $tags = $record->tags;
            if(!isset($tags->$tag)) {
                $createTempRecord = true;
                error_log("There was change in tags");
                $tags->$tag = $tag;
                $product->setTag($tags);
            }

            if($createTempRecord) {
                $newRecord = $this->createTempRecord($product, $record->id);
                if ($newRecord) {
                    $record->fill([
                        'current' => 0
                    ]);
                    $record->save();
                    $record->delete();
                }

                return $newRecord;
            }
                
        } else {
            $data = $product->toArray();
            unset($data['tag']);
            $tag = $product->getTag();
            $data['tags'] = json_encode([$tag => $tag]);
            $data['id'] = $this->model->max('id') + 1;
            $record = $this->create($data);
        }

        return $record;
    }
}