<?php

namespace App\Http\Controllers;

use App\GameSession;
use App\GameTurn;
use App\TurnOrder;
use \App\Upload;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Support\Facades\File;
use ZipArchive;

class DownloadsController extends Controller
{
    public function download($filename)
    {

        $document = Upload::where('filename', $filename)->first();

        $file_path = public_path('images/' . $filename);
        $name = $document->original_name;


        return response()->download($file_path, $name);

    }

    public function zipMultipleFiles($gameTurnId)
    {


        $gameTurn = GameTurn::find($gameTurnId);
        $gameSession = GameSession::find($gameTurn->gamesessions_id);
        $orders = TurnOrder::where("gameturn_id", $gameTurnId)->get();


        $zipname = $gameSession->title . "-" . $gameTurn->title;

        $downloadFolder = "downloads/";
        if (File::exists(public_path("$downloadFolder" . "$zipname.zip"))) {
            File::delete(public_path("$downloadFolder" . "$zipname.zip"));
        }


        Zipper::make(public_path("$downloadFolder" . "$zipname.zip"))->close();
        $category = "turnorders";


        foreach ($orders as $order) {

            $document = Upload::where("category", $category)->where("entity_id", "=", $order->id)->first();
            if ($document != null) {
                Zipper::make(public_path("$downloadFolder" . "$zipname.zip"))->add("images/" . $document->filename, $document->original_name)->close();
            } else {
                $message = "il n'y a pas de fichier à télécharger";
                return redirect()->back()->with('message', $message);
                break;
            }


        }

        return response()->download(public_path("$downloadFolder" . "$zipname.zip"));

    }


}
