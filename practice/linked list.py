class Node:
    def __init__(self, val):
        self.data = val
        self.next = None

class MyLinkedList:

    def __init__(self):
        self.head = None
        self.tail = None

    def _get_node(self, index: int):
        """Returns the node at index, or None if out of bounds."""
        curr = self.head
        for _ in range(index):
            if curr is None:
                return None
            curr = curr.next
        return curr

    def get(self, index: int) -> int:
        if index < 0:
            return -1
        node = self._get_node(index)
        return node.data if node else -1

    def addAtHead(self, val: int) -> None:
        node = Node(val)
        if not self.head:
            self.head = self.tail = node
        else:
            node.next = self.head
            self.head = node

    def addAtTail(self, val: int) -> None:
        node = Node(val)
        if not self.tail:
            self.head = self.tail = node
        else:
            self.tail.next = node
            self.tail = node

    def addAtIndex(self, index: int, val: int) -> None:
        if index <= 0:
            self.addAtHead(val)
            return

        prev = self._get_node(index - 1)
        if prev is None:           # index - 1 doesn't exist → index is too far
            return

        node = Node(val)
        node.next = prev.next
        prev.next = node
        if node.next is None:      # inserted at the end
            self.tail = node

    def deleteAtIndex(self, index: int) -> None:
        if index < 0 or not self.head:
            return

        if index == 0:
            self.head = self.head.next
            if not self.head:
                self.tail = None
            return

        prev = self._get_node(index - 1)
        if prev is None or prev.next is None:   # index - 1 or index doesn't exist
            return

        prev.next = prev.next.next
        if prev.next is None:      # deleted node was the tail
            self.tail = prev