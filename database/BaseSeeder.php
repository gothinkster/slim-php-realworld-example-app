<?php

class BaseSeeder extends \Phinx\Seed\AbstractSeed
{

    const FACTORIES__PATH = ROOT . 'database/factories/';

    /**
     * @var \Illuminate\Database\Eloquent\Factory
     */
    protected $factory;
    /** @var  \Faker\Generator */
    protected $faker;

    protected function init()
    {
        $this->faker = Faker\Factory::create();
        $this->factory = new \Illuminate\Database\Eloquent\Factory($this->faker);
        $factories = glob(static::FACTORIES__PATH . '*.php');
        foreach ($factories as $factory) {
            /** @noinspection PhpIncludeInspection */
            require $factory;
        }
    }
}