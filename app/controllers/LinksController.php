<?php

use Way\Validators\ValidationException;

class LinksController extends BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('links.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
    {
        try
        {
            $hash = Little::make(Input::get('url'));
        }

        catch(ValidationException $e)
        {
            return Redirect::home()->withErrors($e->getErrors())->withInput();
        }

        return Redirect::home()->with([
            'flash_message' => 'All Done',
            'hashed' => $hash
        ]);
    }

    /**
     * Accept hash, and fetch url
     *
     * @param $hash
     *
     * @return mixed
     */
    public function processHash($hash)
    {
        try
        {
            $url = Little::getUrlByHash($hash);

            return Redirect::to($url);
        }

        catch(NonExistentHashException $e)
        {
            return Redirect::home()->with('flash_message', 'No url found');
        }
    }

}
