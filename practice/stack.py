import ctypes

class Stack:    
    
    def __init__(self, capacity = 5):
        self.pointer = -1
        self.array   = (ctypes.c_int32 * capacity)()
        self.size    = capacity
        
    def empty(self):
        return self.pointer == -1
    
    def full(self):
        return self.pointer == self.size - 1
    
    def push(self, val):
        
        if self.full():
            raise Exception('Overflow')
        
        self.pointer += 1
        self.array[self.pointer] = val
    
    def pop(self):
        
        if self.empty():
            raise Exception('Underflow')
        
        val =  self.array[self.pointer]
        self.pointer -= 1
        
        return val
    

    def peek(self):
        
        if self.empty():
            return None
        
        return  self.array[self.pointer]
    
        