<?php

namespace App\Http\Controllers;

// Models
use App\Models\ProductModel;
use App\Models\CategoryModel;

// Mailers
use App\Mail\InquiryReceivedMailer;
use App\Mail\InquirySentMailer;

// Libraries
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 

class ProductController extends Controller
{
    public function foodProducts(Request $request)
    {
        // Only get categories with classification 'Food'
        $categories = CategoryModel::where('classification', 'Food')->get();

        $products = ProductModel::query()
            ->whereHas('category', function ($query) {
                $query->where('classification', 'Food');
            })
            ->when($request->category, function ($query, $categoryUuid) {
                $query->where('category_uuid', $categoryUuid);
            })
            ->when($request->sort, function ($query, $sort) {
                switch ($sort) {
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                    case 'newest':
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            })
            ->with('category')
            ->get();

        return view('pages.products.food', compact('products', 'categories'));
    }

    public function industrialProducts(Request $request)
    {
        // $categories = CategoryModel::where('classification', 'industrial')->get();
        $products = ProductModel::query()
            ->whereHas('category', function ($query) {
                $query->where('classification', 'Industrial');
            })
            ->with('category')
            ->get();

        return view('pages.products.industrial', compact('products'));
    }

    public function redirectInquiry($productName)
    {
        $product = ProductModel::where('name', $productName)->first();

        if(!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        return redirect()->route('pages.inquiry')->with([
            'product_id' => $product->uuid,
            'product_name' => $product->name,
        ]);
    }

    public function inquireMail(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "contact" => "required",
            "subject" => "required",
            "mssg" => "required",
        ]);

        try {
            $inquiry = (object) [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'contact' => $validated['contact'],
                'subject' => $validated['subject'],
                'mssg' => $validated['mssg'],
            ];

            Mail::to($validated['email'])->send(new InquirySentMailer($inquiry)); // Send application to applicant
            Mail::to('koufureceiver@gmail.com')->send(new InquiryReceivedMailer($inquiry)); // Send application to HR
            
            Log::info('Inquiry Received: ' . json_encode($validated));

            return redirect()->back()->with('success', 'Your Inquiry was successfully sent! Please check your email.');
        } catch (\Exception $e) {
            Log::error("Inquiry processing failed: " . $e->getMessage());
    
            return redirect()->back()->with('error', 'There was an error sending your inquiry, please try again later.');
        }
    }
}
