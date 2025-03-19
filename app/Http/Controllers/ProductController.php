<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API Produits",
 *     version="1.0.0",
 *     description="API pour gérer les produits"
 * )
 *
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Produit 1"),
 *     @OA\Property(property="description", type="string", example="Description du produit"),
 *     @OA\Property(property="price", type="number", format="float", example=19.99),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="ProductRequest",
 *     type="object",
 *     required={"name", "price"},
 *     @OA\Property(property="name", type="string", example="Produit 1"),
 *     @OA\Property(property="description", type="string", example="Description du produit"),
 *     @OA\Property(property="price", type="number", format="float", example=19.99)
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Liste tous les produits",
     *     description="Retourne une liste de tous les produits enregistrés.",
     *     operationId="getProducts",
     *     tags={"Produits"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des produits",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Créer un nouveau produit",
     *     description="Crée un nouveau produit avec les données fournies.",
     *     operationId="createProduct",
     *     tags={"Produits"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produit créé avec succès"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation des données échouée"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        return Product::create($request->all());
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Afficher un produit spécifique",
     *     description="Retourne les détails d'un produit spécifique.",
     *     operationId="getProductById",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du produit",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     )
     * )
     */
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Mettre à jour un produit",
     *     description="Met à jour un produit existant avec les données fournies.",
     *     operationId="updateProduct",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProductRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produit mis à jour"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation des données échouée"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Supprimer un produit",
     *     description="Supprime un produit spécifique.",
     *     operationId="deleteProduct",
     *     tags={"Produits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du produit",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Produit supprimé"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->noContent();
    }
}