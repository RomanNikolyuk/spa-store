<?php

namespace App\Observers;

use App\Models\Image;
use Illuminate\Support\Facades\File;

class ImageObserver
{
    /**
     * Handle the Image "created" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */


    public function created(Image $image)
    {
        $unusedImages = Image::where('product_id', 0)->where('slider_id', 0)->where('category_id', 0);

        foreach ($unusedImages->get() as $image) {
            if (File::exists(public_path($image->title))) {
                File::delete(public_path($image->title));
            }
        }
        $unusedImages->delete();
    }

    /**
     * Handle the Image "updated" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function updating(Image $image)
    {

    }

    /**
     * Handle the Image "deleted" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function deleted(Image $image)
    {
        //
    }

    /**
     * Handle the Image "restored" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function restored(Image $image)
    {
        //
    }

    /**
     * Handle the Image "force deleted" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function forceDeleted(Image $image)
    {
        //
    }
}
