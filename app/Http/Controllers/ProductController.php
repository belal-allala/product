<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API Produt",
 *     version="1.0.0",
 *     description="API pour gérer les produits"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Liste tous les produits",
     *     @OA\Response(response="200", description="Liste des produits")
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
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response="201", description="Produit créé")
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Détails du produit")
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(response="200", description="Produit mis à jour")
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
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Produit supprimé")
     * )
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->noContent();
    }
}