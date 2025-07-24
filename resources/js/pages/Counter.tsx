import React from 'react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Props {
    count: number;
    [key: string]: unknown;
}

export default function Counter({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), { action: 'increment' }, {
            preserveState: true,
            preserveScroll: true
        });
    };

    const handleDecrement = () => {
        router.post(route('counter.store'), { action: 'decrement' }, {
            preserveState: true,
            preserveScroll: true
        });
    };

    return (
        <AppShell>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                <div className="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full mx-4">
                    <div className="text-center">
                        <h1 className="text-3xl font-bold text-gray-800 mb-8">
                            Counter App
                        </h1>
                        
                        <div className="mb-8">
                            <div className="text-6xl font-bold text-indigo-600 mb-2">
                                {count}
                            </div>
                            <p className="text-gray-500">Current Count</p>
                        </div>
                        
                        <div className="space-y-4">
                            <Button 
                                onClick={handleIncrement}
                                className="w-full h-12 text-lg font-semibold bg-green-500 hover:bg-green-600 text-white"
                            >
                                + Increment
                            </Button>
                            
                            <Button 
                                onClick={handleDecrement}
                                className="w-full h-12 text-lg font-semibold bg-red-500 hover:bg-red-600 text-white"
                                disabled={count <= 0}
                            >
                                - Decrement
                            </Button>
                        </div>
                        
                        <p className="text-sm text-gray-400 mt-6">
                            Counter value is stored in the database
                        </p>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}