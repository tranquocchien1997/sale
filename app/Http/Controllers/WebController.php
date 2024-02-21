<?php

namespace App\Http\Controllers;

use App\Album;
use App\AlbumType;
use App\Contracts\ElementConfig;
use App\HtmlElement;
use App\Package;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WebController extends Controller
{
    public function home() {
        $elements = HtmlElement::all();

        $elements = array_combine(
            $elements
                ->map(function ($elements) {
                    return "{$elements->group}.{$elements->name}";
                })
                ->toArray(),
            $elements
                ->map(function ($elements) {
                    return $elements->value;
                })
                ->toArray()
        );


        $albums = Album::with('albumType')->get();
        $albumTypes = AlbumType::all();
        $packages = Package::with('details')->get();
        return view('home', compact('elements', 'albums', 'packages', 'albumTypes'));
    }

    public function album() {
        $elements = HtmlElement::all();

        $elements = array_combine(
            $elements
                ->map(function ($elements) {
                    return "{$elements->group}.{$elements->name}";
                })
                ->toArray(),
            $elements
                ->map(function ($elements) {
                    return $elements->value;
                })
                ->toArray()
        );


        $albums = Album::with(['albumType', 'items'])->get()->filter(function ($album) {
            return $album->items->filter(function ($item) {
               return $item->type == ElementConfig::TYPE_VIDEO;
            })->isEmpty();
        });
        $albumTypes = AlbumType::all();
        $packages = Package::with('details')->get();
        return view('album', compact('elements', 'albums', 'packages', 'albumTypes'));
    }


    public function film() {
        $elements = HtmlElement::all();

        $elements = array_combine(
            $elements
                ->map(function ($elements) {
                    return "{$elements->group}.{$elements->name}";
                })
                ->toArray(),
            $elements
                ->map(function ($elements) {
                    return $elements->value;
                })
                ->toArray()
        );


        $albums = Album::with(['albumType', 'items'])->get()->filter(function ($album) {
            return $album->items->filter(function ($item) {
                return $item->type == ElementConfig::TYPE_IMAGE;
            })->isEmpty();
        });
        $albumTypes = AlbumType::all();
        $packages = Package::with('details')->get();
        return view('film', compact('elements', 'albums', 'packages', 'albumTypes'));
    }
    public function albumDetail($id) {
        $elements = HtmlElement::all();

        $elements = array_combine(
            $elements
                ->map(function ($elements) {
                    return "{$elements->group}.{$elements->name}";
                })
                ->toArray(),
            $elements
                ->map(function ($elements) {
                    return $elements->value;
                })
                ->toArray()
        );


        $album = Album::with('albumType', 'items')->where('id', $id)->first();
        return view('album-detail', compact('elements', 'album'));
    }
    public function packageDetail($id) {
        $elements = HtmlElement::all();

        $elements = array_combine(
            $elements
                ->map(function ($elements) {
                    return "{$elements->group}.{$elements->name}";
                })
                ->toArray(),
            $elements
                ->map(function ($elements) {
                    return $elements->value;
                })
                ->toArray()
        );


        $package = Package::with('details')->where('id', $id)->first();

        return view('package-detail', compact('elements', 'package'));
    }
    public function about() {
        $elements = HtmlElement::all();

        $elements = array_combine(
            $elements
                ->map(function ($elements) {
                    return "{$elements->group}.{$elements->name}";
                })
                ->toArray(),
            $elements
                ->map(function ($elements) {
                    return $elements->value;
                })
                ->toArray()
        );
        return view('about', compact('elements'));
    }
}
