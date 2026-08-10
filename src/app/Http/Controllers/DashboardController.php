<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Favorite;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $tab = $request->query('tab');

        if ($tab === 'mylist') {
           $items = auth()->check()
            ? auth()->user()->favoriteItems
            : collect(); 
        } else {
           $items = Item::all();
        }

        return view('index', compact('items', 'tab'));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $tab = $request->tab;

      if ($tab === 'mylist') {

        $items = auth()->user()
            ->favoriteItems()
            ->keywordSearch($keyword)
            ->get();

      } else {

        $items = Item::keywordSearch($keyword)->get();
     }

        return view('index', compact('items', 'tab'));
    }


    public function profile(Request $request)
    {
        return view('profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileRequest $request){
        $user = auth()->user();

    if ($request->hasFile('img')) {
        $path = $request->file('img')->store('profiles', 'public');
        $user->img = $path;
    }

        $user->name = $request->name;
        $user->post_code = $request->post_code;
        $user->address = $request->address;
        $user->building = $request->building;

        $user->save();

         return redirect('/');
    }

    public function send()
    {
        return view('verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/mypage/profile');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect('/home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function create(Request $request){
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell',compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('img')->store('img', 'public');

        $item = Item::create([
        'name' => $request->name,
        'price' => $request->price,
        'img' => $path,
        'detail' => $request->detail,
        'condition_id' => $request->condition_id,
        'user_id' => auth()->user()->id,
        ]);

        $item->categories()->attach($request->category_id);

        return redirect('/');
    }

    public function show($id){

        $item = Item::findOrFail($id);

        return view('item', compact('item'));
    }
    
    public function mypage(Request $request)
    {
        $user = auth()->user();
        $tab = $request->query('tab', 'sell');

       if ($tab === 'buy') {

        $items = Item::whereIn('id', function ($query) use ($user) {
          $query->select('item_id')
                ->from('purchases')
                ->where('user_id', $user->id);
    })->get();
    } else {
        $items = Item::where('user_id', $user->id)->get();
}
        return view('mypage', compact('user', 'items', 'tab'));
    }
    
}
