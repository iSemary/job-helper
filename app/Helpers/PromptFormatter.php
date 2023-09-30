<?php

namespace App\Helpers;

class PromptFormatter {
    public function prepare(string $basePrompt, array $data): string {
        $formattedPrompt = $basePrompt;
        // Replace Major Vars
        $formattedPrompt = str_replace('[Job Description]', $data['job_description'], $formattedPrompt);
        $formattedPrompt = str_replace('[Job Title]', $data['job_title'], $formattedPrompt);
        $formattedPrompt = str_replace('[Company Name]', $data['company_name'], $formattedPrompt);
        // Add company details if exists [Industry, Hr Name, Hr Email, Job Salary]
        if (isset($data['company'])) {
            if (isset($data['company']['industry'])) {
                $formattedPrompt .= " Company industry in: {$data['company']['industry']}";
            }
            if (isset($data['company']['hr_name'])) {
                $formattedPrompt .= " Hr Name is: {$data['company']['hr_name']}";
            }
            if (isset($data['company']['hr_email'])) {
                $formattedPrompt .= " Hr Email is: {$data['company']['hr_email']}";
            }
        }
        // Add User Info if exists
        if (isset($data['user_info'])) {
            if (isset($data['user_info']['first_name'])) {
                $formattedPrompt .= " My first name is: {$data['user_info']['first_name']}";
            }
            if (isset($data['user_info']['last_name'])) {
                $formattedPrompt .= " My last name is: {$data['user_info']['last_name']}";
            }
            if (isset($data['user_info']['email'])) {
                $formattedPrompt .= " My email address is: {$data['user_info']['email']}";
            }
            if (isset($data['user_info']['phone'])) {
                $formattedPrompt .= " My phone number is: {$data['user_info']['phone']}";
            }
            if (isset($data['user_info']['total_experience_years'])) {
                $formattedPrompt .= " My total years of experience is: {$data['user_info']['total_experience_years']}";
            }
            if (isset($data['user_info']['looking_for_relocation']) && $data['user_info']['looking_for_relocation']) {
                $formattedPrompt .= " and I'm ready for relocation at any time ";
            }
        }

        return $formattedPrompt;
    }
}
