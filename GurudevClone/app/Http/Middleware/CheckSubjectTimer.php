<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubjectTimer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $canProceed = $this->canUserProceedToNextSection(
            $request->user()->id,
            $request->session()->get('current_mok_test_id')
        );

        if (!$canProceed) {
            return response()->json(['error' => 'Cannot proceed to the next section.'], 403);
        }
        return $next($request);

    }
    private function canUserProceedToNextSection($userId, $quizId)
    {
        $userQuizDetail = \App\Models\UserQuizDetail::where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->first();

        if (!$userQuizDetail) {
            return false; // User not found or no record for the quiz
        }

        // Decode the JSON data from the category_info column
        $categoryInfo = json_decode($userQuizDetail->category_info, true);

        // Extract the current section based on user progress
        $currentSection = $this->getCurrentSection($categoryInfo);

        if (!$currentSection) {
            return false; // No current section found
        }

        // Extract the time for the current section
        $sectionTime = isset($categoryInfo[$currentSection]) ? $categoryInfo[$currentSection] : null;

        if (!$sectionTime) {
            return false; // No time defined for the current section
        }

        // Add your specific conditions to check if the section time has expired
        // Example: Compare the current time with the expiration time
        $currentTime = now();
        $sectionExpirationTime = now()->addSeconds(strtotime($sectionTime) - strtotime('00:00:00'));

        return $currentTime >= $sectionExpirationTime;
    }
    private function getCurrentSection($categoryInfo)
    {
        // Implement logic to determine the current section based on user progress
        // You might need to fetch the user's progress from another source
        // For now, let's assume it's the first category
        $sections = array_keys($categoryInfo);
        return reset($sections);
    }
    
}   
