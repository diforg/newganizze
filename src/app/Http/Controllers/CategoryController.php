<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $activeTab = $request->string('type')->toString();
        $activeTab = in_array($activeTab, ['expense', 'income'], true) ? $activeTab : 'expense';

        $categories = Category::with('children')
            ->roots()
            ->active()
            ->where(function ($query) use ($activeTab): void {
                $query->where('nature', $activeTab)
                    ->orWhere('nature', 'both');
            })
            ->orderBy('name')
            ->get();

        $archivedCount = Category::roots()
            ->archived()
            ->where(function ($query) use ($activeTab): void {
                $query->where('nature', $activeTab)
                    ->orWhere('nature', 'both');
            })
            ->count();

        return Inertia::render('Categories/Index', compact('categories', 'archivedCount', 'activeTab'));
    }
}