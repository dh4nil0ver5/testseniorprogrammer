r =int(input("Enter the number of rows:"))

for i in range(r,0,-1):
    print("0"*i,end='')
    print(" "*(r-i)*2,end='')
    print("0"*i)

for i in range(1,r+1):
    print("0"*i,end='')
    print(" "*(r-i)*2,end='')
    print("0"*i)