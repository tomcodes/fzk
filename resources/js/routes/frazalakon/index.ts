import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see routes/web.php:95
* @route '/{frazalakon}/like'
*/
export const like = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: like.url(args, options),
    method: 'post',
})

like.definition = {
    methods: ["post"],
    url: '/{frazalakon}/like',
} satisfies RouteDefinition<["post"]>

/**
* @see routes/web.php:95
* @route '/{frazalakon}/like'
*/
like.url = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { frazalakon: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { frazalakon: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            frazalakon: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        frazalakon: typeof args.frazalakon === 'object'
        ? args.frazalakon.slug
        : args.frazalakon,
    }

    return like.definition.url
            .replace('{frazalakon}', parsedArgs.frazalakon.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:95
* @route '/{frazalakon}/like'
*/
like.post = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: like.url(args, options),
    method: 'post',
})

/**
* @see routes/web.php:95
* @route '/{frazalakon}/like'
*/
const likeForm = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: like.url(args, options),
    method: 'post',
})

/**
* @see routes/web.php:95
* @route '/{frazalakon}/like'
*/
likeForm.post = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: like.url(args, options),
    method: 'post',
})

like.form = likeForm

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
export const show = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/{frazalakon}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
show.url = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { frazalakon: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { frazalakon: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            frazalakon: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        frazalakon: typeof args.frazalakon === 'object'
        ? args.frazalakon.slug
        : args.frazalakon,
    }

    return show.definition.url
            .replace('{frazalakon}', parsedArgs.frazalakon.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
show.get = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
show.head = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
const showForm = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
showForm.get = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, options),
    method: 'get',
})

/**
* @see routes/web.php:114
* @route '/{frazalakon}'
*/
showForm.head = (args: { frazalakon: string | { slug: string } } | [frazalakon: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: show.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

show.form = showForm

const frazalakon = {
    like: Object.assign(like, like),
    show: Object.assign(show, show),
}

export default frazalakon