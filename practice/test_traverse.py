import importlib.util
import sys

spec = importlib.util.spec_from_file_location("linked_list", "linked list.py")
mn = importlib.util.module_from_spec(spec)
sys.modules["linked_list"] = mn
spec.loader.exec_module(mn)

LinkedList = mn.LinkedList

ll = LinkedList()
# 1 -> 2 -> 3 -> 4 -> 5
for i in [1, 2, 3, 4, 5]:
    ll.insertTail(i)

print("Original:")
ll.traverse()

print("Delete Head:")
ll.deleteHead()
ll.traverse()

print("Delete Tail:")
ll.deleteTail()
ll.traverse()

print("Delete at index 1 (node with value 3):")
ll.deleteAt(1)
ll.traverse()
