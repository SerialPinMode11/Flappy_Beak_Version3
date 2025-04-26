@extends('layouts.hardware')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Feeding System Settings</h1>
        
        <div class="mt-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">General Settings</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Configure your general feeding system settings.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="farm_name" class="block text-sm font-medium text-gray-700">Farm Name</label>
                                        <input type="text" name="farm_name" id="farm_name" value="Green Valley Farm" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                        <select id="timezone" name="timezone" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            <option>Pacific Time (US & Canada)</option>
                                            <option>Mountain Time (US & Canada)</option>
                                            <option selected>Central Time (US & Canada)</option>
                                            <option>Eastern Time (US & Canada)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="weight_unit" class="block text-sm font-medium text-gray-700">Weight Unit</label>
                                        <select id="weight_unit" name="weight_unit" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            <option selected>Kilograms (kg)</option>
                                            <option>Pounds (lb)</option>
                                            <option>Grams (g)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="default_currency" class="block text-sm font-medium text-gray-700">Default Currency</label>
                                        <select id="default_currency" name="default_currency" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            <option>USD ($)</option>
                                            <option>EUR (€)</option>
                                            <option>GBP (£)</option>
                                            <option selected>PHP (₱)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="feeding_start_time" class="block text-sm font-medium text-gray-700">Default Feeding Start Time</label>
                                        <input type="time" name="feeding_start_time" id="feeding_start_time" value="06:00" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="reminder_time" class="block text-sm font-medium text-gray-700">Feeding Reminder (minutes before)</label>
                                        <input type="number" name="reminder_time" id="reminder_time" value="30" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="about" class="block text-sm font-medium text-gray-700">
                                        Default Feeding Notes
                                    </label>
                                    <div class="mt-1">
                                        <textarea id="about" name="about" rows="3" class="shadow-sm focus:ring-primary focus:border-primary mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Standard feeding instructions...">Check water levels before feeding. Ensure all Pekin ducks have access to feed.</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Brief notes that will be added to all new feeding schedules by default.
                                    </p>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Weight Sensor Configuration</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Configure ESP32 to HX711 to Load Cell connectivity.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="esp32_ip" class="block text-sm font-medium text-gray-700">ESP32 IP Address</label>
                                        <input type="text" name="esp32_ip" id="esp32_ip" value="192.168.1.100" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="esp32_port" class="block text-sm font-medium text-gray-700">ESP32 Port</label>
                                        <input type="number" name="esp32_port" id="esp32_port" value="8080" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="hx711_dout_pin" class="block text-sm font-medium text-gray-700">HX711 DOUT Pin (ESP32)</label>
                                        <select id="hx711_dout_pin" name="hx711_dout_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 39; $i++)
                                                <option {{ $i == 16 ? 'selected' : '' }}>GPIO {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="hx711_sck_pin" class="block text-sm font-medium text-gray-700">HX711 SCK Pin (ESP32)</label>
                                        <select id="hx711_sck_pin" name="hx711_sck_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 39; $i++)
                                                <option {{ $i == 17 ? 'selected' : '' }}>GPIO {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="load_cell_calibration" class="block text-sm font-medium text-gray-700">Load Cell Calibration Factor</label>
                                        <input type="number" name="load_cell_calibration" id="load_cell_calibration" value="420.0876" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="tare_weight" class="block text-sm font-medium text-gray-700">Tare Weight (g)</label>
                                        <input type="number" name="tare_weight" id="tare_weight" value="0" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="weight_threshold" class="block text-sm font-medium text-gray-700">Feed Weight Threshold (g)</label>
                                        <input type="number" name="weight_threshold" id="weight_threshold" value="50" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <p class="mt-1 text-sm text-gray-500">Minimum weight change to trigger a feeding event</p>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="reading_interval" class="block text-sm font-medium text-gray-700">Reading Interval (ms)</label>
                                        <input type="number" name="reading_interval" id="reading_interval" value="500" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="enable_weight_sensor" name="enable_weight_sensor" type="checkbox" checked class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="enable_weight_sensor" class="font-medium text-gray-700">Enable Weight Sensor</label>
                                        <p class="text-gray-500">Activate the load cell for feed weight measurement.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="button" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Calibrate Sensor
                                </button>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Save Configuration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Feeding Mechanism Configuration</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Configure Uno R3 to VC-02 Voice Module to BTS7960 to Worm Gear Motor.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="uno_com_port" class="block text-sm font-medium text-gray-700">Arduino Uno COM Port</label>
                                        <select id="uno_com_port" name="uno_com_port" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            <option>COM1</option>
                                            <option>COM2</option>
                                            <option selected>COM3</option>
                                            <option>COM4</option>
                                            <option>/dev/ttyUSB0</option>
                                            <option>/dev/ttyACM0</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="uno_baud_rate" class="block text-sm font-medium text-gray-700">Baud Rate</label>
                                        <select id="uno_baud_rate" name="uno_baud_rate" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            <option>9600</option>
                                            <option selected>115200</option>
                                            <option>57600</option>
                                            <option>38400</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="vc02_rx_pin" class="block text-sm font-medium text-gray-700">VC-02 RX Pin (Uno)</label>
                                        <select id="vc02_rx_pin" name="vc02_rx_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 2 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="vc02_tx_pin" class="block text-sm font-medium text-gray-700">VC-02 TX Pin (Uno)</label>
                                        <select id="vc02_tx_pin" name="vc02_tx_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 3 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="bts7960_rpwm" class="block text-sm font-medium text-gray-700">BTS7960 RPWM Pin (Uno)</label>
                                        <select id="bts7960_rpwm" name="bts7960_rpwm" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 5 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="bts7960_lpwm" class="block text-sm font-medium text-gray-700">BTS7960 LPWM Pin (Uno)</label>
                                        <select id="bts7960_lpwm" name="bts7960_lpwm" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 6 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="bts7960_ren" class="block text-sm font-medium text-gray-700">BTS7960 R_EN Pin (Uno)</label>
                                        <select id="bts7960_ren" name="bts7960_ren" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 8 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="bts7960_len" class="block text-sm font-medium text-gray-700">BTS7960 L_EN Pin (Uno)</label>
                                        <select id="bts7960_len" name="bts7960_len" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 9 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="motor_speed" class="block text-sm font-medium text-gray-700">Motor Speed (0-255)</label>
                                        <input type="number" name="motor_speed" id="motor_speed" min="0" max="255" value="200" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="feeding_duration" class="block text-sm font-medium text-gray-700">Feeding Duration (seconds)</label>
                                        <input type="number" name="feeding_duration" id="feeding_duration" value="10" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="voice_commands" class="block text-sm font-medium text-gray-700">Voice Commands (VC-02)</label>
                                    <div class="mt-1">
                                        <textarea id="voice_commands" name="voice_commands" rows="3" class="shadow-sm focus:ring-primary focus:border-primary mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">start_feeding,stop_feeding,emergency_stop,status_check</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Comma-separated list of voice commands for the VC-02 module.
                                    </p>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="enable_feeding_mechanism" name="enable_feeding_mechanism" type="checkbox" checked class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="enable_feeding_mechanism" class="font-medium text-gray-700">Enable Feeding Mechanism</label>
                                        <p class="text-gray-500">Activate the worm gear motor for feed dispensing.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="button" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Test Motor
                                </button>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Save Configuration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        
        <div class="mt-10 sm:mt-0 mb-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Microcontroller Communication</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Configure communication between ESP32 and Arduino Uno R3 using Logic Level Shifter.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="esp32_tx_pin" class="block text-sm font-medium text-gray-700">ESP32 TX Pin</label>
                                        <select id="esp32_tx_pin" name="esp32_tx_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 39; $i++)
                                                <option {{ $i == 1 ? 'selected' : '' }}>GPIO {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="esp32_rx_pin" class="block text-sm font-medium text-gray-700">ESP32 RX Pin</label>
                                        <select id="esp32_rx_pin" name="esp32_rx_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 39; $i++)
                                                <option {{ $i == 3 ? 'selected' : '' }}>GPIO {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6 mt-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="uno_tx_pin" class="block text-sm font-medium text-gray-700">Arduino Uno TX Pin</label>
                                        <select id="uno_tx_pin" name="uno_tx_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 1 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="uno_rx_pin" class="block text-sm font-medium text-gray-700">Arduino Uno RX Pin</label>
                                        <select id="uno_rx_pin" name="uno_rx_pin" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 0 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6 mt-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="logic_shifter_hv1" class="block text-sm font-medium text-gray-700">Logic Level Shifter HV1 (ESP32)</label>
                                        <select id="logic_shifter_hv1" name="logic_shifter_hv1" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 39; $i++)
                                                <option {{ $i == 21 ? 'selected' : '' }}>GPIO {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="logic_shifter_lv1" class="block text-sm font-medium text-gray-700">Logic Level Shifter LV1 (Uno)</label>
                                        <select id="logic_shifter_lv1" name="logic_shifter_lv1" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            @for ($i = 0; $i <= 13; $i++)
                                                <option {{ $i == 10 ? 'selected' : '' }}>Digital {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <label for="communication_protocol" class="block text-sm font-medium text-gray-700">Communication Protocol</label>
                                    <select id="communication_protocol" name="communication_protocol" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                        <option selected>Serial</option>
                                        <option>I2C</option>
                                        <option>SPI</option>
                                    </select>
                                </div>
                                
                                <div class="grid grid-cols-6 gap-6 mt-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="communication_baud" class="block text-sm font-medium text-gray-700">Communication Baud Rate</label>
                                        <select id="communication_baud" name="communication_baud" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                                            <option>9600</option>
                                            <option selected>115200</option>
                                            <option>57600</option>
                                            <option>38400</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="data_refresh_rate" class="block text-sm font-medium text-gray-700">Data Refresh Rate (ms)</label>
                                        <input type="number" name="data_refresh_rate" id="data_refresh_rate" value="100" class="mt-1 focus:ring-primary focus:border-primary block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                                <div class="mt-6">
                                    <label for="command_format" class="block text-sm font-medium text-gray-700">Command Format</label>
                                    <div class="mt-1">
                                        <textarea id="command_format" name="command_format" rows="3" class="shadow-sm focus:ring-primary focus:border-primary mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{"cmd":"START_FEED","amount":100,"duration":10}
{"cmd":"STOP_FEED"}
{"cmd":"GET_WEIGHT"}</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Example JSON commands for communication between microcontrollers.
                                    </p>
                                </div>
                                
                                <div class="flex items-start mt-6">
                                    <div class="flex items-center h-5">
                                        <input id="enable_communication" name="enable_communication" type="checkbox" checked class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="enable_communication" class="font-medium text-gray-700">Enable Microcontroller Communication</label>
                                        <p class="text-gray-500">Activate communication between ESP32 and Arduino Uno.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="button" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Test Connection
                                </button>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                    Save Configuration
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        
        <div class="mt-10 sm:mt-0 mb-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">System Diagnostics</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Monitor and test hardware components of the feeding system.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-1 gap-6">
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Hardware Status</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm text-gray-700">ESP32 Connected</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm text-gray-700">Arduino Uno Connected</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm text-gray-700">HX711 Operational</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm text-gray-700">VC-02 Voice Module Ready</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm text-gray-700">BTS7960 Motor Driver Ready</span>
                                        </div>
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                            <span class="text-sm text-gray-700">Worm Gear Motor Operational</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Current Weight Reading</h4>
                                    <div class="flex items-center">
                                        <span class="text-3xl font-bold text-gray-900">245.8</span>
                                        <span class="ml-2 text-lg text-gray-500">grams</span>
                                        <button type="button" class="ml-4 inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                            Tare Scale
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Test Components</h4>
                                        <div class="space-y-2">
                                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <i class="fas fa-weight mr-2"></i>
                                                Test Weight Sensor
                                            </button>
                                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <i class="fas fa-volume-up mr-2"></i>
                                                Test Voice Module
                                            </button>
                                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <i class="fas fa-cog mr-2"></i>
                                                Test Motor
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">System Actions</h4>
                                        <div class="space-y-2">
                                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <i class="fas fa-sync mr-2"></i>
                                                Refresh Connection
                                            </button>
                                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                                <i class="fas fa-upload mr-2"></i>
                                                Update Firmware
                                            </button>
                                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <i class="fas fa-power-off mr-2"></i>
                                                Emergency Stop
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">System Log</h4>
                                    <div class="bg-gray-100 p-3 rounded-md h-32 overflow-y-auto font-mono text-xs">
                                        <div class="text-gray-600">[2023-08-30 08:15:23] System initialized</div>
                                        <div class="text-gray-600">[2023-08-30 08:15:24] ESP32 connected on 192.168.1.100</div>
                                        <div class="text-gray-600">[2023-08-30 08:15:25] Arduino Uno connected on COM3</div>
                                        <div class="text-gray-600">[2023-08-30 08:15:26] HX711 weight sensor calibrated</div>
                                        <div class="text-gray-600">[2023-08-30 08:15:27] VC-02 voice module initialized</div>
                                        <div class="text-green-600">[2023-08-30 08:15:28] All components operational</div>
                                        <div class="text-blue-600">[2023-08-30 08:30:45] Feeding schedule started</div>
                                        <div class="text-gray-600">[2023-08-30 08:30:50] Feed dispensed: 245.8g</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection