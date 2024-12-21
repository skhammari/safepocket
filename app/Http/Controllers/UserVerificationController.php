<?php

namespace App\Http\Controllers;

use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserVerificationController extends Controller
{
    public function showUserLevel()
    {
        $verification = auth()->user()->verification;
        
        if (!$verification) {
            $verification = UserVerification::create([
                'user_id' => auth()->id(),
                'stage' => 1,
                'max_transactions' => 3
            ]);
        }

        return Inertia::render('Profile/Components/UserLevel', [
            'stageOneStatus' => [
                'phone' => $verification->phone_verified,
                'biometric' => $verification->biometric_verified,
                'address' => $verification->address_verified,
                'maxTransactions' => $verification->max_transactions
            ],
            'stageTwoStatus' => [
                'phone' => false,
                'biometric' => false,
                'address' => false,
                'maxTransactions' => 3
            ],
            'currentStage' => $verification->stage
        ]);
    }

    public function updatePhoneNumber(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:20'
        ]);

        $verification = auth()->user()->verification;
        $verification->update([
            'phone_number' => $request->phone_number,
            'phone_verified' => true
        ]);

        return back()->with('success', 'Phone number updated successfully');
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255'
        ]);

        $verification = auth()->user()->verification;
        $verification->update([
            'address' => $request->address,
            'address_verified' => true
        ]);

        return back()->with('success', 'Address updated successfully');
    }

    public function uploadIdDocuments(Request $request)
    {
        $request->validate([
            'id_type' => 'required|in:passport,drivers_license,national_id',
            'id_front' => 'required|image|max:5120', // 5MB max
            'id_back' => 'required|image|max:5120',
        ]);

        $verification = auth()->user()->verification;

        // Store front ID image
        $frontPath = $request->file('id_front')->store('id-documents', 'private');
        
        // Store back ID image
        $backPath = $request->file('id_back')->store('id-documents', 'private');

        $verification->update([
            'id_type' => $request->id_type,
            'id_front_path' => $frontPath,
            'id_back_path' => $backPath,
        ]);

        return back()->with('success', 'ID documents uploaded successfully');
    }

    public function uploadSelfie(Request $request)
    {
        $request->validate([
            'selfie' => 'required|image|max:5120',
        ]);

        $verification = auth()->user()->verification;
        
        // Store selfie image
        $selfiePath = $request->file('selfie')->store('selfies', 'private');

        $verification->update([
            'selfie_path' => $selfiePath,
            'biometric_verified' => true
        ]);

        // Check if all stage 1 verifications are complete
        if ($verification->phone_verified && $verification->address_verified && $verification->biometric_verified) {
            $verification->update(['stage' => 2]);
        }

        return back()->with('success', 'Biometric verification completed successfully');
    }

    public function getVerificationStatus()
    {
        $verification = auth()->user()->verification;
        
        return response()->json([
            'stage' => $verification->stage,
            'phone_verified' => $verification->phone_verified,
            'address_verified' => $verification->address_verified,
            'biometric_verified' => $verification->biometric_verified,
            'max_transactions' => $verification->max_transactions
        ]);
    }
} 