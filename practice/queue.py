import ctypes

class Queue:

    def __init__(self, capacity = 5):
        self.size = capacity
        self.front = -1
        self.rear = -1
        self.array = (ctypes.c_int * capacity)()
    
    def empty(self):
        return self.front == -1

    def full(self):
        return self.rear == self.size - 1

    def enqueue(self, val):
        if self.full():
            raise Exception('Overflow')

        if self.empty():
            self.front = 0

        self.rear += 1
        self.array[self.rear] = val

    def dequeue(self):
        if self.empty():
            raise Exception('Underflow')

        val = self.array[self.front]

        if self.front == self.rear:
            self.front = -1
            self.rear = -1
        else:
            self.front += 1

        return val

    def peek(self):
        if self.empty():
            return None

        return self.array[self.front]
        


queue = Queue()

queue.enqueue(1)
queue.enqueue(2)
queue.enqueue(3)
queue.enqueue(4)
queue.enqueue(5)
    
print(queue.dequeue())
print(queue.dequeue())
print(queue.dequeue())
print(queue.dequeue())
print(queue.dequeue())

queue.enqueue(6)
queue.enqueue(7)
queue.enqueue(8)
queue.enqueue(9)
queue.enqueue(10)
queue.dequeue
queue.enqueue(11)

print(queue.peek())
