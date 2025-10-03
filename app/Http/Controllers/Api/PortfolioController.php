<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    public function index()
    {
        try {
            $portfolios = Portfolio::where('is_published', true)
                ->latest()
                ->get()
                ->map(function ($portfolio) {
                    return [
                        'id' => $portfolio->id,
                        'title' => $portfolio->title,
                        'slug' => $portfolio->slug,
                        'company' => $portfolio->company,
                        'category' => $portfolio->category,
                        'description' => $portfolio->description,
                        'link' => $portfolio->link,
                        'tags' => $portfolio->tags ? $portfolio->tags->pluck('name')->toArray() : [],
                        'image' => $portfolio->getFirstMediaUrl('image') 
                            ? url($portfolio->getFirstMediaUrl('image')) 
                            : null,
                        'gallery' => $portfolio->getMedia('gallery')->map(function($media) {
                            return [
                                'url' => url($media->getUrl()),
                                'thumb' => url($media->getUrl()),
                            ];
                        })->toArray(),
                        'created_at' => $portfolio->created_at->toISOString(),
                    ];
                });

            return response()->json($portfolios);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch portfolios',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($slug)
    {
        try {
            $portfolio = Portfolio::where('slug', $slug)
                ->where('is_published', true)
                ->first();

            if (!$portfolio) {
                return response()->json([
                    'error' => 'Portfolio not found'
                ], 404);
            }

            return response()->json([
                'id' => $portfolio->id,
                'title' => $portfolio->title,
                'slug' => $portfolio->slug,
                'company' => $portfolio->company,
                'category' => $portfolio->category,
                'description' => $portfolio->description,
                'link' => $portfolio->link,
                'tags' => $portfolio->tags ? $portfolio->tags->pluck('name')->toArray() : [],
                'image' => $portfolio->getFirstMediaUrl('image') 
                    ? url($portfolio->getFirstMediaUrl('image')) 
                    : null,
                'gallery' => $portfolio->getMedia('gallery')->map(function($media) {
                    return [
                        'url' => url($media->getUrl()),
                        'thumb' => url($media->getUrl()),
                    ];
                })->toArray(),
                'created_at' => $portfolio->created_at->toISOString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch portfolio',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}