r =int(input("Enter the number of rows:"))

for i in range(r,0,-1):
    print("*"*i,end='')
    print(" "*(r-i)*2,end='')
    print("*"*i)

for i in range(1,r+1):
    print("*"*i,end='')
    print(" "*(r-i)*2,end='')
    print("*"*i)