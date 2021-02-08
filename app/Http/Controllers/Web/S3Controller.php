<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\S3\CreateFolderRequest;
use App\Http\Requests\S3\RenameFileOrFolderRequest;
use App\Http\Requests\S3\UploadFileRequest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

/**
 * Class S3Controller
 *
 * @package App\Http\Controllers\Web
 */
class S3Controller extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $parentDirectory = '';
        $files = Storage::disk('s3')->files();
        $directories = Storage::disk('s3')->directories();

        return view('s3.index', [
            'files' => $files,
            'directories' => $directories,
            'parentDirectory' => $parentDirectory,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function openFolder(Request $request): View
    {
        $directory = $request->get('path');
        $files = Storage::disk('s3')->files($directory);
        $directories = Storage::disk('s3')->directories($directory);

        return view('s3.index', [
            'files' => $files,
            'directories' => $directories,
            'parentDirectory' => $directory,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function createFolderForm(Request $request): View
    {
        $directory = $request->get('path');

        return view('s3.create-folder', [
            'path' => $directory,
        ]);
    }

    /**
     * @param CreateFolderRequest $request
     *
     * @return RedirectResponse
     */
    public function createFolderHandler(CreateFolderRequest $request): RedirectResponse
    {
        $parentPath = $request->get('path');
        $nameFolder = $request->get('name');
        $directoryName = $parentPath . '/' . $nameFolder;

        if (!Storage::exists($directoryName)) {

            Storage::disk('s3')->makeDirectory($directoryName);

        }

        return redirect()->route('s3-open-folder', [
            'path' => $parentPath,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteFile(Request $request): RedirectResponse
    {
        $file = $request->get('file');
        $path = $request->get('path');
        Storage::disk('s3')->delete($file);

        return redirect()->route('s3-open-folder', ['path' => $path]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function deleteFolder(Request $request): RedirectResponse
    {
        $folder = $request->get('folder');
        $path = $request->get('path');
        Storage::disk('s3')->deleteDirectory($folder);

        return redirect()->route('s3-open-folder', ['path' => $path]);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function uploadFile(Request $request): View
    {
        $path = $request->get('path');

        return view('s3.upload-file', [
            'path' => $path,
        ]);
    }

    /**
     * @param UploadFileRequest $request
     *
     * @return RedirectResponse
     */
    public function storeFile(UploadFileRequest $request): RedirectResponse
    {
        $path = $request->get('path');
        $file = $request->file('file');

        if (!$file) {
            return redirect()->route('s3-open-folder', ['path' => $path]);
        }
        $name = $file->getClientOriginalName();
        Storage::disk('s3')->putFileAs($path, $file, $name);

        return redirect()->route('s3-open-folder', ['path' => $path]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function downloadFile(Request $request)
    {
        $file = $request->get('file');
        return Storage::disk('s3')->download($file);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function renameForm(Request $request): View
    {
        $path = $request->get('path');

        return view('s3.rename', [
            'path' => $path,
        ]);
    }

    /**
     * @param RenameFileOrFolderRequest $request
     *
     * @return RedirectResponse
     */
    public function renameHandler(RenameFileOrFolderRequest $request): RedirectResponse
    {
        $oldPath = $request->get('path');
        $newName = $request->get('name');
        $newPath = preg_replace('/[^\/]*$/', $newName, $oldPath, 1);
        preg_match('/.+(?=\/)/', $newPath, $parentDirectory);
        Storage::disk('s3')->move($oldPath, $newPath);

        if ($parentDirectory){
            return redirect()->route('s3-open-folder', ['path' => $parentDirectory[0]]);
        }

        return redirect()->route('s3-open-folder', ['path' => '']);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|RedirectResponse
     */
    public function readFile(Request $request)
    {
        $file = $request->get('file');
        try {
            $text = Storage::disk('s3')->get($file);
            return view('s3.read-file', [
                'text' => $text,
            ]);
        } catch (FileNotFoundException $e) {
            preg_match('/.+(?=\/)/', $file, $parentDirectory);
            return redirect()->route('s3-open-folder', ['path' => $parentDirectory[0]]);
        }
    }
}
