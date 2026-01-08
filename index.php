<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sanjana's Expense Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 font-sans">

    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-slate-800 mb-8 text-center">Expense Tracker Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold mb-4 text-indigo-600">Add New Expense</h2>
                <form action="add_expense.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Expense Title</label>
                        <input type="text" name="title" required class="w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Amount (₹)</label>
                            <input type="number" step="0.01" name="amount" required class="w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" class="w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="Food">Food</option>
                                <option value="Travel">Travel</option>
                                <option value="Bills">Bills</option>
                                <option value="Entertainment">Entertainment</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date_added" required class="w-full p-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">Save Expense</button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-xl font-semibold mb-4 text-indigo-600">Spending Breakdown</h2>
                <div class="relative h-64">
                    <canvas id="expenseChart"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <h2 class="text-xl font-semibold mb-4 text-indigo-600">Recent Transactions</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 uppercase text-xs border-b">
                            <th class="pb-3">Title</th>
                            <th class="pb-3">Category</th>
                            <th class="pb-3">Date</th>
                            <th class="pb-3 text-right">Amount</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <?php
                        include 'db.php';
                        $recent = $conn->query("SELECT * FROM expenses ORDER BY date_added DESC LIMIT 5");
                        while($row = $recent->fetch_assoc()):
                        ?>
                        <tr class="border-b last:border-0 hover:bg-slate-50 transition">
                            <td class="py-4 font-medium"><?php echo $row['title']; ?></td>
                            <td class="py-4"><span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-md text-xs"><?php echo $row['category']; ?></span></td>
                            <td class="py-4 text-sm text-gray-500"><?php echo $row['date_added']; ?></td>
                            <td class="py-4 text-right font-bold text-slate-800">₹<?php echo number_format($row['amount'], 2); ?></td>
                            <td class="py-4">
                                <form action="delete_expense.php" method="POST" onsubmit="return confirm('Delete this expense?');">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div> <script>
    async function loadChart() {
        const response = await fetch('get_data.php');
        const data = await response.json();

        if (data.length === 0) return; // Don't draw if empty

        const categories = data.map(item => item.category);
        const totals = data.map(item => item.total);

        new Chart(document.getElementById('expenseChart'), {
            type: 'doughnut',
            data: {
                labels: categories,
                datasets: [{
                    data: totals,
                    backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } },
                cutout: '70%'
            }
        });
    }
    loadChart();
    </script>
</body>
</html>
