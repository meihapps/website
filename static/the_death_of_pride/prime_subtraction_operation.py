prev = -1
nums = (prev := (num - max(filter(lambda x: max(prev + x, x) < num, primes))) for num in nums)
try:
    for _ in nums:
        pass
    return True
except ValueError:
    return False
