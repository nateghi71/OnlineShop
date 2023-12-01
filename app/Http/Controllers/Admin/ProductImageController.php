<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    public function store($primaryImage, $images ,$product)
    {
        $fileNamePrimaryImage = $this->generateFileName($primaryImage->getClientOriginalName());
        $primaryImage->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNamePrimaryImage);

        $fileNameImages = array();
        foreach ($images as $image) {
            $fileNameImage = $this->generateFileName($image->getClientOriginalName());
            $image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')), $fileNameImage);
            $fileNameImages[] = $fileNameImage;
        }

        $fileNameImages[] = $fileNamePrimaryImage;
        $arraySize = count($fileNameImages);
        $num = 0;

        foreach ($fileNameImages as $fileNameImage) {
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $fileNameImage,
                'is_primary' => ++$num === $arraySize ? 1 : 0,
            ]);
        }
    }

    public function setPrimary(Request $request)
    {
        $request->validate([
            'image_id' => 'required|exists:product_images,id'
        ]);
        $product = Product::findOrFail($request->product_id);

        $newPrimaryImage = ProductImage::findOrFail($request->image_id);
        $previousPrimaryImage = $product->images()->where('is_primary' , 1)->first();
        $tempPreviousPrimaryImage = $product->images()->where('is_primary' , 1)->first();

        $previousPrimaryImage->update([
            'image' => $newPrimaryImage->image
        ]);
        $newPrimaryImage->update([
            'image' => $tempPreviousPrimaryImage->image
        ]);
        return ['images' => $product->images];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit_image' , compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePrimaryImage (Request $request)
    {
        $request->validate([
            'update_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $product = Product::findOrFail($request->product_id);
        $fileName =$this->generateFileName($request->update_image->getClientOriginalName());
        $request->update_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')),$fileName);
        $previousPrimaryImage = $product->images()->where('is_primary' , 1)->first();
        if(File::exists(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')).$previousPrimaryImage->image)){
            File::delete(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')).$previousPrimaryImage->image);
        }
        $previousPrimaryImage->update([
            'image' => $fileName,
        ]);
        return ['images' => $product->images];
    }

    public function add(Request $request)
    {
        $request->validate([
            'add_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $fileName =$this->generateFileName($request->add_image->getClientOriginalName());
        $request->add_image->move(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')),$fileName);
        $product = Product::findOrFail($request->product_id);
        $image = $product->images()->create([
            'image' => $fileName,
            'is_primary' => 0,
        ]);
        return ['images' => $product->images];
    }


    public function destroy(Request $request)
    {
        $image = ProductImage::find($request->image_id);
        $product = Product::find($request->product_id);
        if(File::exists(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')).$image->image)){
            File::delete(public_path(env('PRODUCT_IMAGES_UPLOAD_PATH')).$image->image);
        }
        $image->delete();
        return ['images' => $product->images];
    }

    function generateFileName($name)
    {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        $hour = Carbon::now()->hour;
        $minute = Carbon::now()->minute;
        $second = Carbon::now()->second;
        $microsecond = Carbon::now()->microsecond;
        return $year . '_' . $month . '_' . $day . '_' . $hour . '_' . $minute . '_' . $second . '_' . $microsecond . '_' . $name;
    }
}
