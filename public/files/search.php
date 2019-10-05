  1. $admin = User::where('is_admin',2)->select('is_admin')->first();
    -> why we use select(''). instend of all()
