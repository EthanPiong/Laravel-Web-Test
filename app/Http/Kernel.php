protected $routeMiddleware = [
    // ... other middleware
    'admin' => \App\Http\Middleware\IsAdmin::class,
];
