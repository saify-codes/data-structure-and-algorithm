class Node:
    def __init__(self, data):
        self.data = data
        self.next = None
        
class LinkedList:
    
    x=3
    
    def __init__(self):
        self.head = None
        self.tail = None
        self.size = 0
        
    
    def empty(self):
        return self.head == None and self.tail == None
    
    def insertHead(self, val):
        
        node = Node(val)
        
        if self.empty():
            
            self.head = node
            self.tail = node
        else:
            node.next = self.head
            self.head = node
        
        self.size += 1
        
    def insertTail(self, val):
        
        node = Node(val)
        
        if self.empty():
            
            self.head = node
            self.tail = node
        else:
            self.tail.next = node
            self.tail = node
        
        self.size += 1
        
    def insertMiddle(self, index, val):
        
        node = Node(val)
        
        if index == 0:
            self.insertHead(val)
            return
        
        current = self.head
        
        for _ in range(index - 1):
            
            if current.next == None:
                raise Exception("Index out of bounds")
            
            current = current.next
            
        node.next = current.next
        current.next = node
        
        self.size += 1
            
    
        
        
