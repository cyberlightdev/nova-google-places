<?php

namespace Mknooihuisen\GooglePlaces;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class GooglePlaces extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'google-places';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        //TODO: Figure out how to show this properly.
        //$this->hideFromIndex();
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        $properties = ['address', 'city', 'state', 'postalCode', 'country'];
        $json = [];
        if(!$request->exists($requestAttribute.'-address')) {
            $json = null;
        } else {
            foreach ($properties as $property) {
                $key = $requestAttribute. '-' .$property;
                if($request->has($key)) {
                    $json[$property] = $request[$key];
                }
            }
        }

        $model->{$requestAttribute} = $json;
    }
}
