<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductAttribut;
use App\Entity\ProductAttributCategory;
use App\Entity\ProductBrand;
use App\Entity\ProductCategory;
use App\Entity\ProductCollection;
use App\Entity\ProductRating;
use App\Entity\User;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProductFixtures extends Fixture
{
    /**
     * @var ?ObjectManager
     */
    private ?ObjectManager $manager;

    private Generator $faker;

    public function __construct() {
        $this->manager = null;
        $this->faker = Factory::create();
        $this->faker->addProvider(new Commerce($this->faker));
    }

    public function load(ObjectManager $manager): void {
        $this->manager = $manager;

        $brands = $this->loadProductBrands();
        $collections = $this->loadProductCollections();
        $categories = $this->loadProductCategories();
        $productAttributCategories = $this->loadProductAttributCategories();
        $productAttributs = $this->loadProductAttributs($productAttributCategories);

        $imageNames = [
            "pant-1.png", "pant-2.png", "pant-3.png", "pant-4.png",
            "pull-1.png", "pull-2.png", "pull-3.png", "pull-4.png",
            "shirt-1.png", "shirt-2.png", "shirt-3.png", "shirt-4.png",
        ];

        for ($i = 0; $i < 200; $i++) {
            $product = (new Product())
                ->setName($this->faker->productName())
                ->setPrice($this->faker->randomFloat(2, 1, 100))
                ->setQuantity($this->faker->randomDigit())
                ->setDescription($this->faker->sentences(2, true))
                ->setBrand($this->faker->randomElement($brands))
                ->setCollection($this->faker->randomElement($collections))
                ->setCategory($this->faker->randomElement($categories))
                ->setIsAvailable(1)
                ->setIsNew($this->faker->boolean(20))
                ->setImageUrl("http://localhost:8000/images/products/" . $this->faker->randomElement($imageNames))
                ->setWeight($this->faker->randomFloat(3, 0, 1));

            foreach ($this->faker->randomElements($productAttributs['Taille'], $this->faker->randomFloat(0, 1, count($productAttributs['Taille']))) as $element) {
                $product->addProductAttribut($element);
            }

            foreach ($this->faker->randomElements($productAttributs['Couleur'], $this->faker->randomFloat(0, 1, count($productAttributs['Couleur']))) as $element) {
                $product->addProductAttribut($element);
            }

            foreach ($this->getRandomProductRatings() as $productRating) {
                $product->addProductRating($productRating);
            }

            $manager->persist($product);
        }

        $manager->flush();
    }

    private function loadProductBrands(): array {
        $entities = [];

        foreach (["Adidas", "Nike", "Puma"] as $name) {
            $entity = (new ProductBrand())
                ->setName($name);
            $this->manager->persist($entity);
            $entities[] = $entity;
        }

        $this->manager->flush();

        return $entities;
    }

    private function loadProductCollections(): array {
        $entities = [];

        foreach (["Collection 1", "Collection 2", "Collection 3"] as $name) {
            $entity = (new ProductCollection())
                ->setName($name);
            $this->manager->persist($entity);
            $entities[] = $entity;
        }

        $this->manager->flush();

        return $entities;
    }

    private function loadProductCategories(): array {
        $entities = [];

        foreach (["Casquette", "Chaussure", "Jean", "T-Shirt", "Veste"] as $name) {
            $entity = (new ProductCategory())
                ->setName($name);
            $this->manager->persist($entity);
            $entities[] = $entity;
        }

        $this->manager->flush();

        return $entities;
    }

    private function loadProductAttributCategories(): array {
        $entities = [];

        foreach (["Couleur", "Taille"] as $name) {
            $entity = (new ProductAttributCategory())
                ->setName($name);
            $this->manager->persist($entity);
            $entities[$name] = $entity;
        }

        $this->manager->flush();

        return $entities;
    }

    /**
     * @param ProductAttributCategory[] $productAttributCategories
     *
     * @return array
     */
    private function loadProductAttributs(array $productAttributCategories): array {
        $entities = [
            "Taille" => [],
            "Couleur" => []
        ];

        foreach (["S", "M", "XL", "XXL"] as $name) {
            $entity = (new ProductAttribut())
                ->setName($name)
                ->setValue($name)
                ->setProductAttributCategory($productAttributCategories['Taille']);
            $this->manager->persist($entity);
            $entities["Taille"][$name] = $entity;
        }

        foreach ([["Bleu", "#00F"], ["Green", "#0F0"], ["Red", "#F00"]] as $color) {
            $entity = (new ProductAttribut())
                ->setName($color[0])
                ->setValue($color[1])
                ->setProductAttributCategory($productAttributCategories['Couleur']);
            $this->manager->persist($entity);
            $entities["Couleur"][$color[0]] = $entity;
        }

        $this->manager->flush();

        return $entities;
    }

    private function getRandomProductRatings(): array {
        $entities = [];

        for ($i = 0; $i < $this->faker->randomFloat(0, 1, 7); $i++) {
            $entity = (new ProductRating())
                ->setComment($this->faker->sentences(3, asText: true))
                ->setRating($this->faker->randomFloat(2, 1, 5));
            $this->manager->persist($entity);
            $entities[] = $entity;
        }

        return $entities;
    }
}
