from ctypes import c_int32


class Queue:
    
    def __init__(self, capacity=5):
        self.array   = (c_int32 * capacity)()
        self.size    = capacity
        self.front   = -1 
        self.rear    = -1 
    
    def empty(self):
        return self.front == - 1 and self.rear == -1
    
    def full(self):
        return self.rear == self.size - 1
    
    def enqueue(self, val):
        
        if self.full():
            raise Exception("Overflow")
        
        if self.front == -1:
            self.front += 1
        
        self.rear += 1
        self.array[self.rear] = val
    
    def dequeue(self):
        
        if self.empty():
            raise Exception("Underflow")
        
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
    
    
    
def test_queue():
    # Test 1: Create a queue with default capacity
    queue = Queue()
    assert queue.empty() == True, "Test 1 Failed"
    assert queue.size == 5, "Test 1 Failed"

    # Test 2: Enqueue items until the queue is full
    queue.enqueue(10)
    queue.enqueue(20)
    queue.enqueue(30)
    queue.enqueue(40)
    queue.enqueue(50)
    assert queue.full() == True, "Test 2 Failed"
    assert queue.peek() == 10, "Test 2 Failed"  # front element should be 10
    
    # Test 3: Trying to enqueue into a full queue (Overflow)
    try:
        queue.enqueue(60)
        assert False, "Test 3 Failed"  # Should raise exception
    except Exception as e:
        assert str(e) == "Overflow", "Test 3 Failed"
    
    # Test 4: Dequeue items
    val = queue.dequeue()
    assert val == 10, f"Test 4 Failed, expected 10 but got {val}"
    assert queue.peek() == 20, "Test 4 Failed"  # front element should now be 20
    
    # Test 5: Dequeue all elements one by one
    queue.dequeue()  # 20
    queue.dequeue()  # 30
    queue.dequeue()  # 40
    queue.dequeue()  # 50
    assert queue.empty() == True, "Test 5 Failed"
    
    # Test 6: Try to dequeue from an empty queue (Underflow)
    try:
        queue.dequeue()
        assert False, "Test 6 Failed"  # Should raise exception
    except Exception as e:
        assert str(e) == "Underflow", "Test 6 Failed"
    
    # Test 7: Peek into an empty queue
    queue = Queue()  # Create a new empty queue
    assert queue.peek() == None, "Test 7 Failed"  # Should return None
    
    print("All tests passed!")

# Run all tests
test_queue()
        
        