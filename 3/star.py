rows = 6
i = 1

while i <= rows:
    # Print numbers for the left side of the triangle
    j = 1
    while j <= rows + 1 - i:
        print(i, end=' ')
        j += 1
    
    # Print spaces in the middle
    space = 1
    while space <= 2 * (i - 2):
        print(' ', end=' ')
        space += 1
    
    # Print numbers for the right side of the triangle
    if i != 1:
        j = 1
        while j <= rows + 1 - i:
            print(i, end=' ')
            j += 1
    
    print('')
    i += 1
