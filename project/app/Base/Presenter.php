<?php
namespace App\Base;
use Illuminate\Support\Collection;

abstract class Presenter
{
    abstract protected function presentation($object);

    public function get($data)
    {
        $objectIsArray = is_array($data);
        $objectIsCollection = ($data instanceof Collection);

        if ($objectIsArray || $objectIsCollection) {
            $response = [];
            foreach ($data as $object) {
                $response[] = $this->presentation($object);
            }
        } else {
            $response = $this->presentation($data);
        }

        return $response;
    }
}
