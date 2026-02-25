import importlib.util
import os

file_path = "linked list.py"
module_name = "linked_list"

spec = importlib.util.spec_from_file_location(module_name, file_path)
mn = importlib.util.module_from_spec(spec)
spec.loader.exec_module(mn)

ll = mn.LinkedList()
for i in [1, 2, 3, 4, 5]:
    ll.insertTail(i)

print("Original:", end=" ")
curr = ll.head
while curr:
    print(curr.data, end=" -> ")
    curr = curr.next
print("None")

ll.insertAt(2, "New")

print("After insertAt(2, 'New'):", end=" ")
curr = ll.head
while curr:
    print(curr.data, end=" -> ")
    curr = curr.next
print("None")
