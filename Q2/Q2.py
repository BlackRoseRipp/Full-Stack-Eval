gears = {
    "1": 5,
    "2": 10,
    "3": 15,
    "4": 20
}

class Car:
    def __init__(self):
        self.driver = 1
        self.engine = 1
        self.speed = 0
        self.direction = ''
        self.gear = 1
        self.fuel_level = 5.0
    
    def ignite(self):
        if self.fuel_level > 0:
            print('The car has started')
            self.__burn_fuel()
            self.__turn_belts()
        else:
            print("There is no fuel to use.")
    
    def accelerate(self, duration, direction):
        self.__set_direction(direction)
        for i in range(duration):
            if self.fuel_level > 0:
                self.__burn_fuel()
                self.__set_speed(self.speed + 1)
                if gears[str(self.gear)] < self.speed:
                    self.shift_gears("up")
            else:
                print("There is no more fuel to burn.")

    
    def __burn_fuel(self):
        self.fuel_level -= 0.1
        print("Fuel is being burned.")

    def __turn_belts(self):
        print("Engine belts are turning")

    def shift_gears(self, direction):
        if direction == "up" and self.gear < 5:
            self.gear += 1
            print("The car is now in gear ", self.gear)
        elif direction == "down" and self.gear > 1:
            self.gear -= 1
            print("The car is now in gear ", self.gear)
        else:
            print("Unable to shift in that direction.")

    def __set_direction(self, direction):
        if direction != self.direction:
            self.direction = direction
            print("The direction of the car is now ", direction)

    def __set_speed(self, speed):
        self.speed = speed
        print('The speed is now ', self.speed)

myCar = Car()
myCar.ignite()
myCar.accelerate(7, "forward")
myCar.shift_gears("up")
myCar.accelerate(5, "forward")