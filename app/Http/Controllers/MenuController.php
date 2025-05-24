<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    public function index()
    {
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant) {
            return back()->with('error', 'Restoran bulunamadı!');
        }
        
        $menus = Menu::where('restaurant_id', $restaurant->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('restaurant.menus', compact('menus'));
    }

    public function create()
    {
        return view('restaurant.menu_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'currency' => 'required|string',
            'portion' => 'nullable|string',
            'calories' => 'nullable|numeric',
            'ingredients' => 'nullable|string',
            'extras' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Kullanıcıya ait restoranı bul
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant) {
            return back()->with('error', 'Restoran bulunamadı! Lütfen önce restoran bilgilerinizi güncelleyin.');
        }

        // Görselleri kaydet
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $path = $image->store('menus', 'public');
                    if ($path) {
                        $imagePaths[] = $path;
                    } else {
                        Log::error('Resim yüklenemedi: ' . $image->getClientOriginalName());
                    }
                } catch (\Exception $e) {
                    Log::error('Resim yükleme hatası: ' . $e->getMessage());
                }
            }
        }

        // Menü kaydı
        $menu = new Menu();
        $menu->name = $validated['name'];
        $menu->description = $validated['description'] ?? null;
        $menu->category = $validated['category'];
        $menu->price = $validated['price'];
        $menu->discount_price = $validated['discount_price'] ?? null;
        $menu->currency = $validated['currency'];
        $menu->portion = $validated['portion'] ?? null;
        $menu->calories = $validated['calories'] ?? null;
        $menu->ingredients = $validated['ingredients'] ?? null;
        $menu->extras = $validated['extras'] ?? null;
        $menu->tags = $validated['tags'] ?? null;
        $menu->is_featured = $request->has('is_featured') ? 1 : 0;
        $menu->restaurant_id = $restaurant->id;
        
        if (count($imagePaths)) {
            $menu->images = json_encode($imagePaths);
            Log::info('Kaydedilen resimler: ' . json_encode($imagePaths));
        }
        
        try {
            $menu->save();
            return redirect()->route('restaurant.menus')->with('success', 'Menü başarıyla eklendi!');
        } catch (\Exception $e) {
            Log::error('Menü kaydetme hatası: ' . $e->getMessage());
            return back()->with('error', 'Menü eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function edit(Menu $menu)
    {
        // Menünün bu restorana ait olduğunu kontrol et
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant || $menu->restaurant_id !== $restaurant->id) {
            return back()->with('error', 'Bu menüyü düzenleme yetkiniz yok!');
        }

        return view('restaurant.menu_edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        // Menünün bu restorana ait olduğunu kontrol et
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant || $menu->restaurant_id !== $restaurant->id) {
            return back()->with('error', 'Bu menüyü düzenleme yetkiniz yok!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'currency' => 'required|string',
            'portion' => 'nullable|string',
            'calories' => 'nullable|numeric',
            'ingredients' => 'nullable|string',
            'extras' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        // Görselleri kaydet
        $imagePaths = [];
        if ($request->hasFile('images')) {
            // Eski resimleri sil
            if ($menu->images) {
                $oldImages = json_decode($menu->images);
                foreach ($oldImages as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Yeni resimleri kaydet
            foreach ($request->file('images') as $image) {
                try {
                    $path = $image->store('menus', 'public');
                    if ($path) {
                        $imagePaths[] = $path;
                    }
                } catch (\Exception $e) {
                    Log::error('Resim yükleme hatası: ' . $e->getMessage());
                }
            }
        } else {
            // Mevcut resimleri koru
            $imagePaths = $menu->images ? json_decode($menu->images) : [];
        }

        // Menüyü güncelle
        $menu->name = $validated['name'];
        $menu->description = $validated['description'] ?? null;
        $menu->category = $validated['category'];
        $menu->price = $validated['price'];
        $menu->discount_price = $validated['discount_price'] ?? null;
        $menu->currency = $validated['currency'];
        $menu->portion = $validated['portion'] ?? null;
        $menu->calories = $validated['calories'] ?? null;
        $menu->ingredients = $validated['ingredients'] ?? null;
        $menu->extras = $validated['extras'] ?? null;
        $menu->tags = $validated['tags'] ?? null;
        $menu->is_featured = $request->has('is_featured') ? 1 : 0;
        
        if (count($imagePaths)) {
            $menu->images = json_encode($imagePaths);
        }

        try {
            $menu->save();
            return redirect()->route('restaurant.menus')->with('success', 'Menü başarıyla güncellendi!');
        } catch (\Exception $e) {
            Log::error('Menü güncelleme hatası: ' . $e->getMessage());
            return back()->with('error', 'Menü güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function destroy(Menu $menu)
    {
        // Menünün bu restorana ait olduğunu kontrol et
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        if (!$restaurant || $menu->restaurant_id !== $restaurant->id) {
            return back()->with('error', 'Bu menüyü silme yetkiniz yok!');
        }

        try {
            // Resimleri sil
            if ($menu->images) {
                $images = json_decode($menu->images);
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $menu->delete();
            return redirect()->route('restaurant.menus')->with('success', 'Menü başarıyla silindi!');
        } catch (\Exception $e) {
            Log::error('Menü silme hatası: ' . $e->getMessage());
            return back()->with('error', 'Menü silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 