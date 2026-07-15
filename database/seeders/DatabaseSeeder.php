<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            ['name' => 'Admin', 'password' => 'password']
        );

        Profile::firstOrCreate(['id' => 1], [
            'name' => 'Your Name',
            'role' => 'Full-Stack Developer',
            'tagline' => 'I design and build clean, fast, reliable web applications.',
            'about' => "I'm a full-stack developer who enjoys turning ideas into polished, working products. I care about clean code, good UX, and shipping things that hold up in the real world.\n\nEdit this bio any time from the admin panel at /admin.",
            'email' => 'hello@example.com',
            'location' => 'Remote',
            'github_url' => 'https://github.com',
            'linkedin_url' => 'https://linkedin.com',
            'twitter_url' => null,
        ]);

        $categories = [];
        foreach (['Backend', 'Frontend', 'Tools'] as $index => $name) {
            $categories[$name] = SkillCategory::firstOrCreate(['name' => $name], ['sort_order' => $index]);
        }

        $skills = [
            ['name' => 'PHP', 'category' => 'Backend', 'level' => 90, 'sort_order' => 1],
            ['name' => 'Laravel', 'category' => 'Backend', 'level' => 90, 'sort_order' => 2],
            ['name' => 'MySQL', 'category' => 'Backend', 'level' => 80, 'sort_order' => 3],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'level' => 85, 'sort_order' => 1],
            ['name' => 'Vue / Alpine', 'category' => 'Frontend', 'level' => 75, 'sort_order' => 2],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'level' => 85, 'sort_order' => 3],
            ['name' => 'Git', 'category' => 'Tools', 'level' => 85, 'sort_order' => 1],
            ['name' => 'Docker', 'category' => 'Tools', 'level' => 70, 'sort_order' => 2],
        ];

        foreach ($skills as $skill) {
            $categoryName = $skill['category'];
            unset($skill['category']);
            $skill['category_id'] = $categories[$categoryName]->id;

            Skill::firstOrCreate(['name' => $skill['name']], $skill);
        }

        $projects = [
            [
                'title' => 'TaskFlow — Project Management Dashboard',
                'slug' => 'taskflow-dashboard',
                'summary' => 'A Kanban-style project management tool with boards, task assignment, and deadline tracking.',
                'description' => "A longer description of the project: the goal, your role, and the outcome.\n\nThis is placeholder text — edit it from the admin panel with details about the real project.",
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=TaskFlow',
                'tech_stack' => 'Laravel, Tailwind CSS, MySQL',
                'featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'ShopCart — E-Commerce Platform',
                'slug' => 'shopcart-ecommerce-platform',
                'summary' => 'A full-featured storefront with cart, checkout, and order management.',
                'description' => 'Full case-study text goes here — replace with details about the real project.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=ShopCart',
                'tech_stack' => 'Vue, Node.js, PostgreSQL',
                'featured' => false,
                'sort_order' => 2,
            ],
            [
                'title' => 'ChatSphere — Real-Time Messaging App',
                'slug' => 'chatsphere-messaging-app',
                'summary' => 'A real-time chat application with channels, typing indicators, and read receipts.',
                'description' => 'Full case-study text goes here: the goal, the approach, and the outcome. Edit this from the admin panel.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=ChatSphere',
                'tech_stack' => 'React, Node.js, MongoDB',
                'featured' => false,
                'sort_order' => 3,
            ],
            [
                'title' => 'InvoicePro — Invoicing & Billing Tool',
                'slug' => 'invoicepro-billing-tool',
                'summary' => 'An invoicing tool for freelancers and small teams, with recurring billing and PDF exports.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=InvoicePro',
                'tech_stack' => 'Laravel, Livewire, Tailwind CSS',
                'featured' => false,
                'sort_order' => 4,
            ],
            [
                'title' => 'DevBlog — Developer Blogging Platform',
                'slug' => 'devblog-platform',
                'summary' => 'A minimal blogging platform for developers, with syntax-highlighted code snippets.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=DevBlog',
                'tech_stack' => 'Next.js, TypeScript, PostgreSQL',
                'featured' => false,
                'sort_order' => 5,
            ],
            [
                'title' => 'FleetTrack — Fleet Management System',
                'slug' => 'fleettrack-management-system',
                'summary' => 'A dashboard for tracking vehicle locations, maintenance schedules, and driver logs.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=FleetTrack',
                'tech_stack' => 'Laravel, Vue, Docker',
                'featured' => false,
                'sort_order' => 6,
            ],
            [
                'title' => 'MetricHub — Analytics Dashboard',
                'slug' => 'metrichub-analytics-dashboard',
                'summary' => 'A customizable analytics dashboard with live charts and exportable reports.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=MetricHub',
                'tech_stack' => 'React, GraphQL, PostgreSQL',
                'featured' => false,
                'sort_order' => 7,
            ],
            [
                'title' => 'QuickBook — Appointment Booking System',
                'slug' => 'quickbook-appointment-booking',
                'summary' => 'An online booking system with calendar sync, reminders, and payment collection.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=QuickBook',
                'tech_stack' => 'Python, Django, Redis',
                'featured' => false,
                'sort_order' => 8,
            ],
            [
                'title' => 'NoteNest — Note-Taking App',
                'slug' => 'notenest-app',
                'summary' => 'A note-taking app with tags, full-text search, and offline support.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=NoteNest',
                'tech_stack' => 'Laravel, Alpine.js, MySQL',
                'featured' => false,
                'sort_order' => 9,
            ],
            [
                'title' => 'EventHive — Event Management Platform',
                'slug' => 'eventhive-platform',
                'summary' => 'An event management platform for ticketing, RSVPs, and attendee check-in.',
                'description' => 'Full case-study text goes here.',
                'image_url' => 'https://placehold.co/800x450/0a0a0a/34d399?text=EventHive',
                'tech_stack' => 'Node.js, Express, MongoDB',
                'featured' => false,
                'sort_order' => 10,
            ],
        ];

        // Remove the old generically-named placeholder rows left over from earlier seed runs.
        Project::whereIn('slug', [
            'sample-project-one', 'sample-project-two', 'sample-project-three', 'sample-project-four',
            'sample-project-five', 'sample-project-six', 'sample-project-seven', 'sample-project-eight',
            'sample-project-nine', 'sample-project-ten',
        ])->delete();

        foreach ($projects as $project) {
            Project::firstOrCreate(['slug' => $project['slug']], $project);
        }

        $experiences = [
            [
                'company' => 'Sample Company Inc.',
                'role' => 'Senior Full-Stack Developer',
                'location' => 'Remote',
                'start_date' => '2023-01-01',
                'end_date' => null,
                'description' => "Leading development of the core product platform.\nReplace this with your real work history from the admin panel.",
                'sort_order' => 1,
            ],
            [
                'company' => 'Previous Company Ltd.',
                'role' => 'Full-Stack Developer',
                'location' => 'Remote',
                'start_date' => '2020-06-01',
                'end_date' => '2022-12-31',
                'description' => 'Built and maintained web applications for clients across industries.',
                'sort_order' => 2,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::firstOrCreate(
                ['company' => $experience['company'], 'role' => $experience['role']],
                $experience
            );
        }

        $testimonials = [
            [
                'author_name' => 'Jamie Rivera',
                'author_role' => 'Product Manager, Sample Co.',
                'content' => 'A pleasure to work with — communicates clearly, delivers on time, and the code quality speaks for itself. Replace this with a real quote from someone you\'ve worked with.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'author_name' => 'Alex Chen',
                'author_role' => 'CTO, Another Co.',
                'content' => 'Turned a vague idea into a polished, working product faster than we expected. Highly recommended.',
                'rating' => 5,
                'sort_order' => 2,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::firstOrCreate(['author_name' => $testimonial['author_name']], $testimonial);
        }
    }
}
