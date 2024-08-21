/*
Copyright 2024 Reviive Shop Web

Permission is hereby granted, free of charge, to any person obtaining a copy of this
software and associated documentation files (the “Software”), to deal in the Software
without restriction, including without limitation the rights to use, copy, modify, merge,
publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies
or substantial portions of the Software.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
// Sysinfo.c - 2024 Dakotath.
#include <stdio.h>
#include <stdint.h>
#include <stdlib.h>
#include <sys/sysinfo.h>
#include <unistd.h>
#include <string.h>

// CPU type.
const char *cpuType() {
    #if defined(__x86_64__) || defined(_M_X64)
        return "x86_64";
    #elif defined(i386) || defined(__i386__) || defined(__i386) || defined(_M_IX86)
        return "x86_32";
    #elif defined(__ARM_ARCH_2__)
        return "ARM2";
    #elif defined(__ARM_ARCH_3__) || defined(__ARM_ARCH_3M__)
        return "ARM3";
    #elif defined(__ARM_ARCH_4T__) || defined(__TARGET_ARM_4T)
        return "ARM4T";
    #elif defined(__ARM_ARCH_5_) || defined(__ARM_ARCH_5E_)
        return "ARM5"
    #elif defined(__ARM_ARCH_6T2_) || defined(__ARM_ARCH_6T2_)
        return "ARM6T2";
    #elif defined(__ARM_ARCH_6__) || defined(__ARM_ARCH_6J__) || defined(__ARM_ARCH_6K__) || defined(__ARM_ARCH_6Z__) || defined(__ARM_ARCH_6ZK__)
        return "ARM6";
    #elif defined(__ARM_ARCH_7__) || defined(__ARM_ARCH_7A__) || defined(__ARM_ARCH_7R__) || defined(__ARM_ARCH_7M__) || defined(__ARM_ARCH_7S__)
        return "ARM7";
    #elif defined(__ARM_ARCH_7A__) || defined(__ARM_ARCH_7R__) || defined(__ARM_ARCH_7M__) || defined(__ARM_ARCH_7S__)
        return "ARM7A";
    #elif defined(__ARM_ARCH_7R__) || defined(__ARM_ARCH_7M__) || defined(__ARM_ARCH_7S__)
        return "ARM7R";
    #elif defined(__ARM_ARCH_7M__)
        return "ARM7M";
    #elif defined(__ARM_ARCH_7S__)
        return "ARM7S";
    #elif defined(__aarch64__) || defined(_M_ARM64)
        return "ARM64";
    #elif defined(mips) || defined(__mips__) || defined(__mips)
        return "MIPS";
    #elif defined(__sh__)
        return "SUPERH";
    #elif defined(__powerpc) || defined(__powerpc__) || defined(__powerpc64__) || defined(__POWERPC__) || defined(__ppc__) || defined(__PPC__) || defined(_ARCH_PPC)
        return "POWERPC";
    #elif defined(__PPC64__) || defined(__ppc64__) || defined(_ARCH_PPC64)
        return "POWERPC64";
    #elif defined(__sparc__) || defined(__sparc)
        return "SPARC";
    #elif defined(__m68k__)
        return "M68K";
    #else
        return "UNKNOWN";
    #endif
}

// Strings.
char* profanity[] = {
    "System Info Utility\n",
    "Dakotath",
    "Reviive Shop",
    "This software was developed for %s by %s\n",
    "This program should only be installed on the \"%s\" server\n",
    "This file is under the MIT License.\n",
    
    // Version
    "%s Compiled on %s for CPU type of %s.\n",
    "STDC Version: %ld\n",

    // Main.
    "Unknown option: %s\n",
    "Unhandled argument: %s\n"
};

// Strings enum.
typedef enum {
    LANG_EN_APPNAME = 0,
    LANG_EN_APPAUTH,
    LANG_EN_APPCOMP,
    LANG_EN_DEVFORBY,
    LANG_EN_PROVLOC,
    LANG_EN_WARNTXT,

    // Version (EN),
    LANG_EN_APPVERSTR,
    LANG_EN_STDCV,

    // Main.
    LANG_EN_UNKOPT,
    LANG_EN_UHARG
} ProfanityEnum;

// Big ol' fat list of args.
typedef enum {
    ARG_NONE = 0,
    ARG_VERSION,
    ARG_MEMTOTAL,
    ARG_MEMFREE,
    ARG_MEMUSED,
    ARG_CPULOAD,
    ARG_UNKNOWN
} ArgType;

// Do I must haz explain this one?
ArgType get_arg_type(const char *arg) {
    if (strcmp(arg, "-v") == 0) return ARG_VERSION;
    if (strcmp(arg, "-mt") == 0) return ARG_MEMTOTAL;
    if (strcmp(arg, "-mf") == 0) return ARG_MEMFREE;
    if (strcmp(arg, "-mu") == 0) return ARG_MEMUSED;
    if (strcmp(arg, "-cl") == 0) return ARG_CPULOAD;
    return ARG_UNKNOWN;
}

// Print version and stuff.
void printVersion() {
    // App version.
    printf(profanity[LANG_EN_APPNAME]);
    printf(profanity[LANG_EN_APPVERSTR],
        __FILE__,
        __DATE__,
        cpuType()
    );

    // STDC Version.
    #ifdef __STDC_VERSION__
    printf(profanity[LANG_EN_STDCV], (long) __STDC_VERSION__);
    #endif

    // App Developer notices.
    printf(profanity[LANG_EN_DEVFORBY],
        profanity[LANG_EN_APPCOMP],
        profanity[LANG_EN_APPAUTH]
    ); printf(profanity[LANG_EN_PROVLOC],
        profanity[LANG_EN_APPCOMP]
    ); printf(profanity[LANG_EN_WARNTXT]);
}

// Function to get total memory
unsigned long long handle_memtotal() {
    long pages = sysconf(_SC_PHYS_PAGES);
    long page_size = sysconf(_SC_PAGE_SIZE);
    if (pages == -1 || page_size == -1) {
        perror("sysconf");
        return 0;
    }
    printf("%llu", pages * page_size);
    return pages * page_size;
}

// Function to get free memory
unsigned long long handle_memfree() {
    long pages = sysconf(_SC_AVPHYS_PAGES);
    long page_size = sysconf(_SC_PAGE_SIZE);
    if (pages == -1 || page_size == -1) {
        perror("sysconf");
        return 0;
    }
    printf("%llu", pages * page_size);
    return pages * page_size;
}

// This little shit doesn't work on Windows or Linux for some reason.
void handle_memused() {
    unsigned long long total_memory = handle_memtotal();
    unsigned long long free_memory = handle_memfree();
    unsigned long long used_memory = total_memory - free_memory;
    printf("%llu", used_memory);
}

// Function to get CPU load
void handle_cpuload() {
    double loadavg[3];
    if (getloadavg(loadavg, 3) == -1) {
        perror("getloadavg");
    } else {
        printf("1 min load average: %.2f\n", loadavg[0]);
        printf("5 min load average: %.2f\n", loadavg[1]);
        printf("15 min load average: %.2f\n", loadavg[2]);
    }
}

// CLI processing
void process_arguments(int argc, char **argv) {
    for (int i = 1; i < argc; i++) {
        ArgType arg_type = get_arg_type(argv[i]);
        
        switch (arg_type) {
            case ARG_VERSION:
                printVersion();
                break;
            case ARG_MEMTOTAL:
                handle_memtotal();
                break;
            case ARG_MEMUSED:
                handle_memused();
                break;
            case ARG_MEMFREE:
                handle_memfree();
                break;
            case ARG_CPULOAD:
                handle_cpuload();
                break;
            case ARG_UNKNOWN:
                printf("Unknown option: %s\n", argv[i]);
                break;
            default:
                printf("Unhandled argument: %s\n", argv[i]);
                break;
        }
    }
}

// Main.
void main(int argc, char** argv) {
    process_arguments(argc, argv);
}