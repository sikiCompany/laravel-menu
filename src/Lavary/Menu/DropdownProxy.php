<?php

namespace Lavary\Menu;

class DropdownProxy
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var int|string
     */
    protected $parentId;

    /**
     * @param Builder    $builder
     * @param int|string $parentId
     */
    public function __construct(Builder $builder, $parentId)
    {
        $this->builder = $builder;
        $this->parentId = $parentId;
    }

    /**
     * @param array|string $options
     *
     * @return array
     */
    protected function withParent($options)
    {
        if (!is_array($options)) {
            $options = [];
        }
        $options['parent'] = $this->parentId;

        return $options;
    }

    /**
     * @param string       $title
     * @param string|array $options
     *
     * @return Item
     */
    public function add($title, $options = '')
    {
        if (!is_array($options)) {
            $url = $options;
            $options = [];
            $options['url'] = $url;
        }

        return $this->builder->add($title, $this->withParent($options));
    }

    /**
     * @param string $title
     * @param array  $options
     *
     * @return Item
     */
    public function raw($title, array $options = [])
    {
        return $this->builder->raw($title, $this->withParent($options));
    }

    /**
     * @param string $url
     * @param string $title
     * @param array  $options
     *
     * @return Item
     */
    public function url($url, $title, array $options = [])
    {
        $options['url'] = $url;

        return $this->builder->add($title, $this->withParent($options));
    }

    /**
     * @param string   $title
     * @param \Closure $callback
     * @param array    $options
     *
     * @return Item
     */
    public function dropdown($title, \Closure $callback, array $options = [])
    {
        $item = $this->add($title, $options);
        $callback(new static($this->builder, $item->id));

        return $item;
    }
}
